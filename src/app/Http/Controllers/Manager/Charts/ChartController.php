<?php

namespace App\Http\Controllers\Manager\Charts;

use App\Http\Controllers\Controller;

use App\Models\Manager\Person;
use App\Models\Manager\TipoOcupacion;
use Carbon\Carbon;
use Inertia\Inertia;

class ChartController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Charts/Index');
    }

    public function getChartAdultosOcupadosData()
    {
        // Obtener el ID del tipo de ocupación "DESEMPLEADO"
        $tipoDesocupado = TipoOcupacion::where('description', 'DESEMPLEADO')->first();
        $desocupado_id = $tipoDesocupado ? $tipoDesocupado->id : null;

        // Filtrar personas mayores de 18 años directamente en la consulta
        $fechaCorte = Carbon::now()->subYears(18);

        // Obtener personas con ocupación (no desempleados ni nulos)
        $conOcupacion = Person::where('fecha_nac', '<', $fechaCorte)
            ->whereHas('social', function($query) use ($desocupado_id) {
                $query->whereNotNull('tipo_ocupacion_id')
                      ->when($desocupado_id, function($q) use ($desocupado_id) {
                          $q->where('tipo_ocupacion_id', '!=', $desocupado_id);
                      });
            })
            ->selectRaw('genero, COUNT(*) as total')
            ->groupBy('genero')
            ->get();

        // Obtener personas sin ocupación (desempleados)
        $sinOcupacion = Person::where('fecha_nac', '<', $fechaCorte)
            ->whereHas('social', function($query) use ($desocupado_id) {
                $query->where('tipo_ocupacion_id', $desocupado_id);
            })
            ->selectRaw('genero, COUNT(*) as total')
            ->groupBy('genero')
            ->get();

        // Obtener personas sin información de ocupación
        $noInformado = Person::where('fecha_nac', '<', $fechaCorte)
            ->whereDoesntHave('social')
            ->orWhereHas('social', function($query) {
                $query->whereNull('tipo_ocupacion_id');
            })
            ->selectRaw('genero, COUNT(*) as total')
            ->groupBy('genero')
            ->get();

        // Función para procesar los resultados agrupados
        $procesarResultados = function($resultados) {
            $hombres = $resultados->where('genero', 'M')->first()->total ?? 0;
            $mujeres = $resultados->where('genero', 'F')->first()->total ?? 0;
            $noInformadoGenero = $resultados->whereNotIn('genero', ['M', 'F'])->sum('total');

            return compact('hombres', 'mujeres', 'noInformadoGenero');
        };

        $conOcupacionGenero = $procesarResultados($conOcupacion);
        $sinOcupacionGenero = $procesarResultados($sinOcupacion);
        $noInformadoGenero = $procesarResultados($noInformado);

        // Estructura de datos para el chart 3D
        $data = [
            "series" => []
        ];

        // Con Ocupación
        $totalConOcupacion = $conOcupacion->sum('total');
        if ($totalConOcupacion > 0) {
            $breakdown = [];
            if ($conOcupacionGenero['hombres'] > 0) {
                $breakdown[] = [
                    "name" => "Hombres",
                    "value" => $conOcupacionGenero['hombres']
                ];
            }
            if ($conOcupacionGenero['mujeres'] > 0) {
                $breakdown[] = [
                    "name" => "Mujeres",
                    "value" => $conOcupacionGenero['mujeres']
                ];
            }
            if ($conOcupacionGenero['noInformadoGenero'] > 0) {
                $breakdown[] = [
                    "name" => "Género no informado",
                    "value" => $conOcupacionGenero['noInformadoGenero']
                ];
            }

            $data["series"][] = [
                "name" => "Con Ocupación",
                "value" => $totalConOcupacion,
                "color" => "#10B981",
                "breakdown" => $breakdown
            ];
        }

        // Sin Ocupación
        $totalSinOcupacion = $sinOcupacion->sum('total');
        if ($totalSinOcupacion > 0) {
            $breakdown = [];
            if ($sinOcupacionGenero['hombres'] > 0) {
                $breakdown[] = [
                    "name" => "Hombres",
                    "value" => $sinOcupacionGenero['hombres']
                ];
            }
            if ($sinOcupacionGenero['mujeres'] > 0) {
                $breakdown[] = [
                    "name" => "Mujeres",
                    "value" => $sinOcupacionGenero['mujeres']
                ];
            }
            if ($sinOcupacionGenero['noInformadoGenero'] > 0) {
                $breakdown[] = [
                    "name" => "Género no informado",
                    "value" => $sinOcupacionGenero['noInformadoGenero']
                ];
            }

            $data["series"][] = [
                "name" => "Sin Ocupación",
                "value" => $totalSinOcupacion,
                "color" => "#EF4444",
                "breakdown" => $breakdown
            ];
        }

        // No Informado
        $totalNoInformado = $noInformado->sum('total');
        if ($totalNoInformado > 0) {
            $breakdown = [];
            if ($noInformadoGenero['hombres'] > 0) {
                $breakdown[] = [
                    "name" => "Hombres",
                    "value" => $noInformadoGenero['hombres']
                ];
            }
            if ($noInformadoGenero['mujeres'] > 0) {
                $breakdown[] = [
                    "name" => "Mujeres",
                    "value" => $noInformadoGenero['mujeres']
                ];
            }
            if ($noInformadoGenero['noInformadoGenero'] > 0) {
                $breakdown[] = [
                    "name" => "Género no informado",
                    "value" => $noInformadoGenero['noInformadoGenero']
                ];
            }

            $data["series"][] = [
                "name" => "Ocupación No Informada",
                "value" => $totalNoInformado,
                "color" => "#6B7280",
                "breakdown" => $breakdown
            ];
        }

        return response()->json($data);
    }

    public function getChartOcupacionesDonutData()
    {
        // Obtener el ID del tipo de ocupación "DESEMPLEADO" para excluirlo
        $tipoDesocupado = TipoOcupacion::where('description', 'DESEMPLEADO')->first();
        $desocupado_id = $tipoDesocupado ? $tipoDesocupado->id : null;

        // Filtrar personas mayores de 18 años directamente en la consulta
        $fechaCorte = Carbon::now()->subYears(18);

        // Obtener ocupaciones válidas con conteos usando consulta SQL eficiente con tabla correcta
        $ocupaciones = TipoOcupacion::join('social_data as sd', 'tipo_ocupacion.id', '=', 'sd.tipo_ocupacion_id')
            ->join('person', 'person.id', '=', 'sd.person_id')
            ->where('person.fecha_nac', '<', $fechaCorte)
            ->whereNotNull('sd.tipo_ocupacion_id')
            ->when($desocupado_id, function($query) use ($desocupado_id) {
                $query->where('sd.tipo_ocupacion_id', '!=', $desocupado_id);
            })
            ->selectRaw('tipo_ocupacion.description as nombre, COUNT(*) as cantidad')
            ->groupBy('tipo_ocupacion.id', 'tipo_ocupacion.description')
            ->orderBy('cantidad', 'desc')
            ->get();

        // Si no hay datos, devolver estructura vacía
        if ($ocupaciones->isEmpty()) {
            return response()->json([]);
        }

        // Convertir a formato para el gráfico de dona
        $data = [];
        $colores = [
            "#d94126", "#f5ee38", "#6376DD", "#42d392", "#d98320",
            "#10B981", "#3B82F6", "#8B5CF6", "#F59E0B", "#EF4444",
            "#6B7280", "#EC4899", "#14B8A6", "#F97316", "#84CC16"
        ];

        foreach ($ocupaciones as $index => $ocupacion) {

            $nombre = $ocupacion->nombre;

            if( str_contains($nombre, 'EMPLEADO SECTOR PÚBLICO')){
                $nombre = 'EMPLEADO PÚBLICO';
            }elseif(str_contains($nombre, 'EMPLEADO SECTOR PRIVADO')){
                $nombre = 'EMPLEADO PRIVADO';
            }

            $data[] = [
                "name" => $nombre,
                "values" => [$ocupacion->cantidad],
                "color" => $colores[$index % count($colores)]
            ];
        }

        return response()->json($data);
    }

    public function getHeatmapSinOcupacionData()
    {
        // Filtrar personas mayores de 18 años directamente en la consulta
        $fechaCorte = Carbon::now()->subYears(18);

        // Obtener personas DESEMPLEADAS con direcciones y localidades en una sola consulta
        $personasDesempleadas = Person::select([
                'person.id',
                'person.name',
                'person.lastname',
                'localidades.id as localidad_id',
                'localidades.description as localidad_nombre',
                'localidades.latitud',
                'localidades.longitud'
            ])
            ->join('social_data as sd', 'person.id', '=', 'sd.person_id')
            ->join('address_data as ad', 'person.id', '=', 'ad.person_id')
            ->join('localidades', 'ad.localidad_id', '=', 'localidades.id')
            ->where('person.fecha_nac', '<', $fechaCorte)
            ->where('sd.tipo_ocupacion_id', 6) // DESEMPLEADO
            ->whereNotNull('localidades.latitud')
            ->whereNotNull('localidades.longitud')
            ->get();

        // Preparar datos para el mapa de calor - UN PUNTO POR PERSONA
        $heatmapData = [];
        $contadorPorLocalidad = []; // Para distribuir puntos alrededor del centro

        foreach ($personasDesempleadas as $persona) {
            $localidadId = $persona->localidad_id;

            // Inicializar contador para esta localidad
            if (!isset($contadorPorLocalidad[$localidadId])) {
                $contadorPorLocalidad[$localidadId] = 0;
            }

            // Generar desplazamiento aleatorio dentro de un radio de 300 metros
            $radio = 0.003; // Aproximadamente 300 metros en coordenadas
            $angulo = fmod($contadorPorLocalidad[$localidadId] * 137.5, 360); // Ángulo dorado para mejor distribución
            $distancia = sqrt(($contadorPorLocalidad[$localidadId] + 1) / 10) * $radio; // Distribución en espiral

            // Convertir a radianes
            $anguloRad = deg2rad($angulo);

            // Calcular desplazamiento
            $deltaLat = $distancia * cos($anguloRad);
            $deltaLng = $distancia * sin($anguloRad);

            // Aplicar desplazamiento a las coordenadas de la base de datos
            $latFinal = $persona->latitud + $deltaLat;
            $lngFinal = $persona->longitud + $deltaLng;

            $heatmapData[] = [
                'person_id' => $persona->id,
                'localidad_id' => $localidadId,
                'localidad_nombre' => $persona->localidad_nombre,
                'person_name' => $persona->name . ' ' . $persona->lastname,
                'coordenadas' => [
                    'lat' => $latFinal,
                    'lng' => $lngFinal
                ]
            ];

            $contadorPorLocalidad[$localidadId]++;
        }

        return response()->json($heatmapData);
    }

    public function getCantPersonsData(){
        // Contar directamente en la base de datos sin cargar registros
        $count = Person::count();
        return response()->json($count);
    }

    public function getChartOcupacionesPorEdadData()
    {
        // Obtener el ID del tipo de ocupación "DESEMPLEADO" para excluirlo
        $tipoDesocupado = TipoOcupacion::where('description', 'DESEMPLEADO')->first();
        $desocupado_id = $tipoDesocupado ? $tipoDesocupado->id : null;

        // Filtrar personas mayores de 18 años directamente en la consulta
        $fechaCorte = Carbon::now()->subYears(18);

                // Definir rangos de edad en SQL usando CASE WHEN
        $rangoEdadSQL = "
            CASE
                WHEN TIMESTAMPDIFF(YEAR, person.fecha_nac, CURDATE()) BETWEEN 18 AND 24 THEN '18-24'
                WHEN TIMESTAMPDIFF(YEAR, person.fecha_nac, CURDATE()) BETWEEN 25 AND 34 THEN '25-34'
                WHEN TIMESTAMPDIFF(YEAR, person.fecha_nac, CURDATE()) BETWEEN 35 AND 49 THEN '35-49'
                WHEN TIMESTAMPDIFF(YEAR, person.fecha_nac, CURDATE()) BETWEEN 50 AND 59 THEN '50-59'
                WHEN TIMESTAMPDIFF(YEAR, person.fecha_nac, CURDATE()) BETWEEN 60 AND 64 THEN '60-64'
                WHEN TIMESTAMPDIFF(YEAR, person.fecha_nac, CURDATE()) >= 65 THEN '65+'
                ELSE NULL
            END as rango_edad
        ";

        // Obtener datos agrupados por ocupación y rango de edad
        $datos = TipoOcupacion::join('social_data as sd', 'tipo_ocupacion.id', '=', 'sd.tipo_ocupacion_id')
            ->join('person', 'person.id', '=', 'sd.person_id')
            ->where('person.fecha_nac', '<', $fechaCorte)
            ->whereNotNull('sd.tipo_ocupacion_id')
            ->when($desocupado_id, function($query) use ($desocupado_id) {
                $query->where('sd.tipo_ocupacion_id', '!=', $desocupado_id);
            })
            ->selectRaw("tipo_ocupacion.description as ocupacion, {$rangoEdadSQL}, COUNT(*) as cantidad")
            ->havingRaw('rango_edad IS NOT NULL')
            ->groupBy('tipo_ocupacion.id', 'tipo_ocupacion.description', 'rango_edad')
            ->orderBy('tipo_ocupacion.description')
            ->get();

        // Si no hay datos, devolver estructura vacía
        if ($datos->isEmpty()) {
            return response()->json([]);
        }

        // Obtener todas las ocupaciones únicas
        $ocupaciones = $datos->pluck('ocupacion')->unique()->sort()->values()->toArray();

        // Definir rangos de edad
        $rangos_edad = ['18-24', '25-34', '35-49', '50-59', '60-64', '65+'];

        // Crear matriz de datos organizados
        $ocupacionesPorEdad = [];
        foreach ($ocupaciones as $ocupacion) {
            $ocupacionesPorEdad[$ocupacion] = array_fill_keys($rangos_edad, 0);
        }

        // Llenar la matriz con los datos obtenidos
        foreach ($datos as $dato) {
            $ocupacionesPorEdad[$dato->ocupacion][$dato->rango_edad] = $dato->cantidad;
        }

        // Estructurar datos para VueUiStackbar
        $series = [];
        $colores = [
            "#d94126", "#f5ee38", "#6376DD", "#42d392", "#d98320", "#10B981"
        ];

        foreach ($rangos_edad as $index => $rango) {
            $data = [];
            foreach ($ocupaciones as $ocupacion) {
                $data[] = $ocupacionesPorEdad[$ocupacion][$rango];
            }

            $series[] = [
                'name' => $rango,
                'data' => $data,
                'color' => $colores[$index % count($colores)]
            ];
        }

        $result = [
            'categories' => $ocupaciones,
            'series' => $series
        ];

        return response()->json($result);
    }




}
