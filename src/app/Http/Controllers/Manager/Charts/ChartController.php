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
        // Obtener personas con sus datos sociales
        $personas = Person::with('social.tipoOcupacion')->get();
        $personas_mayores_18 = $personas->filter(function($persona) {
            return $persona->fecha_nac < Carbon::now()->subYears(18);
        });

        // Obtener el ID del tipo de ocupación "DESEMPLEADO"
        $tipoDesocupado = TipoOcupacion::where('description', 'DESEMPLEADO')->first();
        $desocupado_id = $tipoDesocupado ? $tipoDesocupado->id : null;

        // Categorizar personas por ocupación
        $conOcupacion = [];
        $sinOcupacion = [];
        $noInformado = [];

        foreach ($personas_mayores_18 as $persona) {
            $socialData = $persona->social->first(); // Tomar el primer registro social

            if (!$socialData || $socialData->tipo_ocupacion_id === null) {
                // Sin información de ocupación
                $noInformado[] = $persona;
            } elseif ($socialData->tipo_ocupacion_id === $desocupado_id) {
                // Desocupado
                $sinOcupacion[] = $persona;
            } else {
                // Con ocupación
                $conOcupacion[] = $persona;
            }
        }

        // Función para contar por género
        $contarPorGenero = function($personas) {
            $hombres = 0;
            $mujeres = 0;
            $noInformadoGenero = 0;

            foreach ($personas as $persona) {

                if ($persona->genero == 'M') {
                    $hombres++;
                } elseif ($persona->genero == 'F') {
                    $mujeres++;
                } else {
                    $noInformadoGenero++;
                }
            }

            return compact('hombres', 'mujeres', 'noInformadoGenero');
        };

        // Contar por categoría y género
        $conOcupacionGenero = $contarPorGenero($conOcupacion);
        $sinOcupacionGenero = $contarPorGenero($sinOcupacion);
        $noInformadoGenero = $contarPorGenero($noInformado);

        // Estructura de datos para el chart 3D
        $data = [
            "series" => []
        ];

        // Con Ocupación
        if (count($conOcupacion) > 0) {
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
                "value" => count($conOcupacion),
                "color" => "#10B981",
                "breakdown" => $breakdown
            ];
        }

        // Sin Ocupación
        if (count($sinOcupacion) > 0) {
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
                "value" => count($sinOcupacion),
                "color" => "#EF4444",
                "breakdown" => $breakdown
            ];
        }

        // No Informado
        if (count($noInformado) > 0) {
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
                "value" => count($noInformado),
                "color" => "#6B7280",
                "breakdown" => $breakdown
            ];
        }

        return response()->json($data);
    }

    public function getChartOcupacionesDonutData()
    {
        // Obtener personas con sus datos sociales y tipos de ocupación
        $personas = Person::with('social.tipoOcupacion')->get();

        // Filtrar personas mayores de 18 años
        $personas_mayores_18 = $personas->filter(function($persona) {
            return $persona->fecha_nac < Carbon::now()->subYears(18);
        });

        // Obtener el ID del tipo de ocupación "DESEMPLEADO" para excluirlo
        $tipoDesocupado = TipoOcupacion::where('description', 'DESEMPLEADO')->first();
        $desocupado_id = $tipoDesocupado ? $tipoDesocupado->id : null;

        // Recopilar ocupaciones válidas (no NULL y no DESEMPLEADO)
        $ocupaciones = [];

        foreach ($personas_mayores_18 as $persona) {
            $socialData = $persona->social->first();

            // Verificar que tenga datos sociales, tipo de ocupación válido y no sea desempleado
            if ($socialData &&
                $socialData->tipo_ocupacion_id !== null &&
                $socialData->tipo_ocupacion_id !== $desocupado_id &&
                $socialData->tipoOcupacion) {

                $nombreOcupacion = $socialData->tipoOcupacion->description;

                if (!isset($ocupaciones[$nombreOcupacion])) {
                    $ocupaciones[$nombreOcupacion] = 0;
                }
                $ocupaciones[$nombreOcupacion]++;
            }
        }

        // Calcular total para porcentajes
        $total = array_sum($ocupaciones);

        // Si no hay datos, devolver estructura vacía
        if ($total === 0) {
            return response()->json([]);
        }

        // Convertir a formato para el gráfico de dona
        $data = [];
        $colores = [
            "#d94126", "#f5ee38", "#6376DD", "#42d392", "#d98320",
            "#10B981", "#3B82F6", "#8B5CF6", "#F59E0B", "#EF4444",
            "#6B7280", "#EC4899", "#14B8A6", "#F97316", "#84CC16"
        ];

        $index = 0;
        foreach ($ocupaciones as $nombre => $cantidad) {
            $data[] = [
                "name" => $nombre,
                "values" => [$cantidad],
                "color" => $colores[$index % count($colores)]
            ];
            $index++;
        }

        return response()->json($data);
    }

        public function getHeatmapSinOcupacionData()
    {
        // Obtener personas desempleadas con direcciones y localidades con coordenadas
        $personas = Person::with(['social.tipoOcupacion', 'address.localidad'])->get();

        // Filtrar personas mayores de 18 años
        $personas_mayores_18 = $personas->filter(function($persona) {
            return $persona->fecha_nac < Carbon::now()->subYears(18);
        });

        // Encontrar personas DESEMPLEADAS (tipo_ocupacion_id = 6)
        $personasDesempleadas = $personas_mayores_18->filter(function($persona) {
            $socialData = $persona->social->first();
            return $socialData && $socialData->tipo_ocupacion_id === 6;
        });

        // Filtrar solo las que tienen address_data con localidad_id y coordenadas
        $personasConDireccion = $personasDesempleadas->filter(function($persona) {
            $addressData = $persona->address->first();
            if (!$addressData || !$addressData->localidad_id) {
                return false;
            }

            $localidad = $addressData->localidad;
            return $localidad && $localidad->latitud !== null && $localidad->longitud !== null;
        });

        // Preparar datos para el mapa de calor - UN PUNTO POR PERSONA
        $heatmapData = [];
        $contadorPorLocalidad = []; // Para distribuir puntos alrededor del centro

        foreach ($personasConDireccion as $persona) {
            $addressData = $persona->address->first();
            $localidad = $addressData->localidad;
            $localidadId = $localidad->id;

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
            $latFinal = $localidad->latitud + $deltaLat;
            $lngFinal = $localidad->longitud + $deltaLng;

            $heatmapData[] = [
                'person_id' => $persona->id,
                'localidad_id' => $localidadId,
                'localidad_nombre' => $localidad->description,
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

}
