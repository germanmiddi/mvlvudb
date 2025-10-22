<?php

namespace App\Http\Controllers\Manager\Charts;

use App\Http\Controllers\Controller;

use App\Models\Manager\Person;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\Tramite;
use App\Models\Manager\Dependencia;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

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

    /**
     * Obtener distribución de trámites por dependencia (para gráfico de dona)
     * Filtrado por los últimos 30 días
     */
    public function getTramitesPorDependenciaData()
    {
        // Calcular fecha de hace 30 días
        $fechaInicio = Carbon::now()->subDays(30);

        // Obtener trámites agrupados por dependencia con nombres (últimos 30 días)
        $tramitesPorDependencia = Tramite::select(
                'dependencias.id',
                'dependencias.description as nombre',
                DB::raw('COUNT(tramites.id) as cantidad')
            )
            ->join('dependencias', 'tramites.dependencia_id', '=', 'dependencias.id')
            ->where('tramites.fecha', '>=', $fechaInicio)
            ->groupBy('dependencias.id', 'dependencias.description')
            ->orderBy('cantidad', 'desc')
            ->get();

        // Si no hay datos, devolver estructura vacía
        if ($tramitesPorDependencia->isEmpty()) {
            return response()->json([]);
        }

        // Colores para cada dependencia
        $colores = [
            "#3B82F6", // Azul
            "#EF4444", // Rojo
            "#10B981", // Verde
            "#F59E0B", // Amarillo/Naranja
            "#8B5CF6", // Púrpura
            "#EC4899", // Rosa
            "#14B8A6", // Teal
            "#F97316", // Naranja
            "#84CC16", // Lima
            "#6366F1", // Indigo
            "#06B6D4", // Cyan
        ];

        // Función para abreviar nombres largos
        $abreviarNombre = function($nombre) {
            // Mapeo de abreviaciones específicas
            $abreviaciones = [
                'Centro Barriales Infancia' => 'CBI',
                'Centro Barriales Juventud' => 'CBJ',
                'Discapacidad' => 'Discapacidad',
                'Entidades Intermedias' => 'Ent. Intermedias',
                'Fortalecimiento Comunitario' => 'Fort. Comunitario',
                'Género y Diversidad' => 'Género y Div.',
                'Habitat' => 'Hábitat',
                'Niñez y Adolescencia' => 'Niñez y Adol.',
                'Promoción y Protección de Derechos' => 'Prom. y Protección',
                'Personas Mayores' => 'Pers. Mayores',
                'Vivienda Social' => 'Vivienda Social'
            ];

            // Si existe una abreviación específica, usarla
            if (isset($abreviaciones[$nombre])) {
                return $abreviaciones[$nombre];
            }

            // Si el nombre es muy largo, truncarlo
            if (strlen($nombre) > 20) {
                return substr($nombre, 0, 17) . '...';
            }

            return $nombre;
        };

        // Convertir a formato para el gráfico de dona
        $data = [];
        foreach ($tramitesPorDependencia as $index => $item) {
            $data[] = [
                "name" => $abreviarNombre($item->nombre),
                "values" => [$item->cantidad],
                "color" => $colores[$index % count($colores)]
            ];
        }

        return response()->json($data);
    }

    /**
     * Obtener evolución temporal de trámites (últimos 6 meses)
     */
    public function getEvolucionTramitesData()
    {
        // Calcular fecha de inicio (6 meses atrás)
        $fechaInicio = Carbon::now()->subMonths(6)->startOfMonth();

        // Obtener trámites agrupados por mes
        $tramitesPorMes = Tramite::select(
                DB::raw('DATE_FORMAT(fecha, "%Y-%m") as mes'),
                DB::raw('COUNT(*) as cantidad')
            )
            ->where('fecha', '>=', $fechaInicio)
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        // Generar array con todos los meses (para llenar vacíos)
        $meses = [];
        $categorias = [];
        $valores = [];

        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i)->format('Y-m');
            $mesNombre = Carbon::now()->subMonths($i)->locale('es')->isoFormat('MMM YYYY');

            $categorias[] = $mesNombre;

            // Buscar si hay datos para este mes
            $dato = $tramitesPorMes->firstWhere('mes', $mes);
            $valores[] = $dato ? $dato->cantidad : 0;
        }

        // Formato para VueUiXy (gráfico de líneas)
        $result = [
            'categories' => $categorias,
            'series' => [
                [
                    'name' => 'Trámites',
                    'values' => $valores,
                    'type' => 'line'
                ]
            ]
        ];

        return response()->json($result);
    }

    /**
     * Obtener estadísticas generales para tarjetas mejoradas
     */
    public function getStatsGeneralesData()
    {
        // Total de personas
        $totalPersonas = Person::count();

        // Personas nuevas (últimos 30 días)
        $fechaInicio30Dias = Carbon::now()->subDays(30);
        $personasNuevas = Person::where('created_at', '>=', $fechaInicio30Dias)->count();

        // Trámites del mes actual
        $tramitesMesActual = Tramite::whereYear('fecha', Carbon::now()->year)
            ->whereMonth('fecha', Carbon::now()->month)
            ->count();

        // Trámites del mes anterior
        $tramitesMesAnterior = Tramite::whereYear('fecha', Carbon::now()->subMonth()->year)
            ->whereMonth('fecha', Carbon::now()->subMonth()->month)
            ->count();

        // Calcular porcentaje de cambio
        $porcentajeCambio = 0;
        if ($tramitesMesAnterior > 0) {
            $porcentajeCambio = round((($tramitesMesActual - $tramitesMesAnterior) / $tramitesMesAnterior) * 100, 1);
        } elseif ($tramitesMesActual > 0) {
            $porcentajeCambio = 100;
        }

        // ===== TRÁMITES DE LOS ÚLTIMOS 30 DÍAS =====
        $fechaInicio = Carbon::now()->subDays(30);

        // Total de trámites de los últimos 30 días
        $totalUltimos30Dias = Tramite::where('fecha', '>=', $fechaInicio)->count();

        // Trámites por estado (últimos 30 días)
        $tramitesAbiertos = Tramite::where('fecha', '>=', $fechaInicio)
            ->where('estado_id', 1) // abierto
            ->count();

        $tramitesEnProceso = Tramite::where('fecha', '>=', $fechaInicio)
            ->where('estado_id', 3) // en proceso
            ->count();

        $tramitesCerrados = Tramite::where('fecha', '>=', $fechaInicio)
            ->where('estado_id', 2) // cerrado
            ->count();

        // Calcular porcentaje de trámites cerrados
        $porcentajeCerrados = 0;
        if ($totalUltimos30Dias > 0) {
            $porcentajeCerrados = round(($tramitesCerrados / $totalUltimos30Dias) * 100, 1);
        }

        return response()->json([
            'totalPersonas' => [
                'total' => $totalPersonas,
                'nuevas' => $personasNuevas
            ],
            'tramitesMes' => [
                'cantidad' => $tramitesMesActual,
                'porcentajeCambio' => $porcentajeCambio,
                'tendencia' => $porcentajeCambio >= 0 ? 'up' : 'down'
            ],
            // Trámites últimos 30 días con desglose por estado
            'tramitesUltimos30Dias' => [
                'total' => $totalUltimos30Dias,
                'abiertos' => $tramitesAbiertos,
                'enProceso' => $tramitesEnProceso,
                'cerrados' => $tramitesCerrados
            ],
            // Porcentaje de trámites cerrados
            'porcentajeCerrados' => $porcentajeCerrados
        ]);
    }

}
