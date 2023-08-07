<?php

namespace App\Http\Controllers\Manager\Tramites\Juventud;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Manager\Uploads\FileController;
use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\ActividadCbj;
//Models
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CbjData;
use App\Models\Manager\CentroSalud;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\Comedor;
use App\Models\Manager\ContactData;
use App\Models\Manager\ContactoEmergencia;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Escuela;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\EscuelaNivel;
use App\Models\Manager\EscuelaTurno;
use App\Models\Manager\EstadoCbj;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\EstadoSalud;
use App\Models\Manager\Familiar;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\OrientacionEscuela;
use App\Models\Manager\Parentesco;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoPension;
use App\Models\Manager\TipoVivienda;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\RolTramite;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\Person;
use App\Models\Manager\SaludData;
use App\Models\Manager\Sede;
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JuventudController extends Controller
{
    //index

    public function index()
    {
        return Inertia::render(
            'Manager/Tramites/Juventud/Index',
            [
                'tiposTramite' => TipoTramite::where('dependencia_id', 13)->get(),
                'toast' => Session::get('toast')
            ]
        );
    }

    //create
    public function create()
    {
        return Inertia::render(
            'Manager/Tramites/Juventud/Create',
            [
                'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::all(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 13)->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::all(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'estadosCbj' => EstadoCbj::where('activo', true)->get(),
                'sedes' => Sede::all(),
                'escuelasPrimarias' => Escuela::where('primaria', true)->get(),
                'escuelasSecundarias' => Escuela::where('secundaria', true)->get(),
                'escuelasNocturnas' => Escuela::where('nocturna', true)->get(),
                'orientaciones' => OrientacionEscuela::where('activo', true)->get(),
                'escuelasTurnos' => EscuelaTurno::all(),
                'escuelasDependencias' => EscuelaDependencia::all(),
                'centrosSalud' => CentroSalud::where('activo', true)->get(),
                'estadosSalud' => EstadoSalud::where('activo', true)->get(),
            ]
        );
    }

    //store
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            /**
             * Datos Genericos del tramite.
             */

            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento']
                ],
                [
                    'lastname' => $request['lastname'],
                    'name' => $request['name'],
                    'fecha_nac' => $request['fecha_nac'],
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento'],
                    'num_cuit' => $request['num_cuit'] ?? null
                ]
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => $request['calle'],
                    'number' => $request['number'],
                    'piso' => $request['piso'],
                    'dpto' => $request['dpto'],
                    'latitude' => $request['latitude'],
                    'longitude' => $request['longitude'],
                    'google_address' => $request['google_address'],
                    'pais_id' => $request['pais_id'],
                    'localidad_id' => $request['localidad_id'],
                    'barrio_id' => $request['barrio_id'],

                ]
            );

            AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $request['cant_hijos'],
                    'situacion_conyugal_id' => $request['situacion_conyugal_id']
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'subsidio' => $request['subsidio']
                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $request['phone'],
                    'email' => $request['email']
                ]
            );

            if ($request['beneficiario_control'] == 'true') {
                // Datos del Beneficiario
                $beneficiario = Person::updateOrCreate(
                    [
                        'tipo_documento_id' => $request['beneficiario_tipo_documento_id'],
                        'num_documento' => $request['beneficiario_num_documento']
                    ],
                    [
                        'lastname' => $request['beneficiario_lastname'],
                        'name' => $request['beneficiario_name'],
                        'fecha_nac' => $request['beneficiario_fecha_nac'],
                        'tipo_documento_id' => $request['beneficiario_tipo_documento_id'],
                        'num_documento' => $request['beneficiario_num_documento'],
                        'num_cuit' => $request['beneficiario_num_cuit'] ?? null
                    ]
                );

                $beneficiario_id = $beneficiario->id;
            } else {
                // Datos adicionales del Titular
                $beneficiario_id = $person->id;
            }

            AddressData::updateOrCreate(
                [
                    'person_id' => $beneficiario_id
                ],
                [
                    'calle' => $request['calle'],
                    'number' => $request['number'],
                    'piso' => $request['piso'],
                    'dpto' => $request['dpto'],
                    'localidad_id' => $request['localidad_id'],
                    'barrio_id' => $request['barrio_id'],

                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $beneficiario_id
                ],
                [
                    'nivel_educativo_id' => $request['beneficiario_nivel_educativo_id'],
                    'estado_educativo_id' => $request['beneficiario_estado_educativo_id'],
                    'escuela_primaria_id' => $request['beneficiario_escuela_primaria_id'],
                    'escuela_secundaria_id' => $request['beneficiario_escuela_secundaria_id'],
                    'escuela_nocturna_id' => $request['beneficiario_escuela_nocturna_id'],
                    'orientacion_secundario_id' => $request['beneficiario_orientacion_secundario_id'],
                    'nivel_secundario_id' => $request['beneficiario_nivel_secundario_id'],
                    'turno_nocturno_id' => $request['beneficiario_turno_nocturno_id'],
                    'dependencia_nocturno_id' => $request['beneficiario_dependencia_nocturno_id'],
                    'terciario' => $request['beneficiario_terciario'],
                    'name_terciaria' => $request['beneficiario_name_terciaria'],
                    'carrera_terciaria' => $request['beneficiario_carrera_terciaria'],
                    'anio_terciario' => $request['beneficiario_anio_terciario'],
                    'universitario' => $request['beneficiario_universitario'],
                    'name_universitaria' => $request['beneficiario_name_universitaria'],
                    'carrera_universitaria' => $request['beneficiario_carrera_universitaria'],
                    'anio_universitario' => $request['beneficiario_anio_universitario']
                ]
            );

            SaludData::updateOrCreate(
                [
                    'person_id' => $beneficiario_id
                ],
                [
                    'apto_medico' => $request['beneficiario_apto_medico'],
                    'libreta_vacunacion' => $request['beneficiario_libreta_vacunacion'],
                    'centro_salud_id' => $request['beneficiario_centro_salud_id'],
                    'estado_salud_id' => $request['beneficiario_estado_salud_id'],
                    'observacion' => $request['beneficiario_observacion_salud'],
                    'fecha_apto_medico' => $request['beneficiario_fecha_apto_medico'],
                    'electrocardiograma' => $request['beneficiario_electrocardiograma'],
                    'fecha_electrocardiograma' => $request['beneficiario_fecha_electrocardiograma'],
                    'medicacion' => $request['beneficiario_medicacion'],
                    'name_medicacion' => $request['beneficiario_name_medicacion'],
                    'dosis' => $request['beneficiario_dosis'],
                ]
            );

            $list_tramites_id = array();

            // tramite
            if ($request['tramites_id'] != null) {

                foreach ($request['tramites_id'] as $indice => $valor) {

                    // Obtengo ID de la dependencia.
                    $dependencia = TipoTramite::where('id', $request['tramites_id'][$indice])->first();

                    $tramite_data = Tramite::Create(
                        [
                            'fecha' => date("Y-m-d ", strtotime($request['fecha'])),
                            'observacion' => $request['tramites_observacion'][$indice],

                            'canal_atencion_id' => $request['canal_atencion_id'],
                            'tipo_tramite_id' => $request['tramites_id'][$indice],
                            'dependencia_id' => $dependencia['dependencia_id'],
                            'parentesco_id' => $request['parentesco_id'],
                        ]
                    );

                    CbjData::Create(
                        [
                            'anio_inicio' => $request['anio_inicio'],
                            'aut_firmada' => $request['aut_firmada'],
                            'aut_retirarse' => $request['aut_retirarse'],
                            'aut_uso_imagen' => $request['aut_uso_imagen'],
                            'comedor_id' => $request['comedor_id'],
                            'estado_cbj_id' => $request['estado_cbj_id'],
                            'acompanamiento_cbj_id'  => $request['acompanamiento_cbj_id'],
                            'tramite_id' => $tramite_data['id']
                        ]
                    );

                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]);
                    if (isset($beneficiario)) {
                        $beneficiario->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
                    }

                    // Verifico si existe familiar asociado.

                    if ($request['familiar_id']) {
                        foreach ($request['familiar_id'] as $indice => $valor) {
                            $familiar = Person::updateOrCreate(
                                [
                                    'tipo_documento_id' => $request['familiar_tipo_documento_id'][$indice],
                                    'num_documento' => $request['familiar_num_documento'][$indice]
                                ],
                                [
                                    'lastname' => $request['familiar_lastname'][$indice],
                                    'name' => $request['familiar_name'][$indice],
                                    'fecha_nac' => $request['familiar_fecha_nac'][$indice],
                                    'tipo_documento_id' => $request['familiar_tipo_documento_id'][$indice],
                                    'num_documento' => $request['familiar_num_documento'][$indice]
                                ]
                            );

                            Familiar::updateOrCreate(
                                [
                                    'person_id' => $familiar['id'],
                                    'tramite_id' => $tramite_data['id'],
                                    'parentesco_id' => $request['familiar_parentesco_id'][$indice]
                                ]
                            );
                        }
                    }

                    // Verifico si existe Contacto de Emergencia asociado.

                    if ($request['contacto_id']) {
                        foreach ($request['contacto_id'] as $indice => $valor) {
                            $contacto = Person::updateOrCreate(
                                [
                                    'tipo_documento_id' => $request['contacto_tipo_documento_id'][$indice],
                                    'num_documento' => $request['contacto_num_documento'][$indice]
                                ],
                                [
                                    'lastname' => $request['contacto_lastname'][$indice],
                                    'name' => $request['contacto_name'][$indice],
                                    'fecha_nac' => $request['contacto_fecha_nac'][$indice],
                                    'tipo_documento_id' => $request['contacto_tipo_documento_id'][$indice],
                                    'num_documento' => $request['contacto_num_documento'][$indice]
                                ]
                            );

                            ContactData::updateOrCreate(
                                [
                                    'person_id' => $contacto['id']
                                ],
                                [
                                    'phone' => $request['contacto_phone'][$indice],
                                    'email' => $request['contacto_email'][$indice]
                                ]
                            );

                            ContactoEmergencia::updateOrCreate(
                                [
                                    'person_id' => $contacto['id'],
                                    'tramite_id' => $tramite_data['id'],
                                    'parentesco_id' => $request['contacto_parentesco_id'][$indice]
                                ]
                            );
                        }
                    }

                    if ($request['files'] != null) {
                        foreach ($request['files'] as $indice => $valor) {

                            $fileController = new FileController;
                            $data = [];

                            $data['base64'] = $request['files'][$indice];
                            $data['tramite_id'] =  $tramite_data['id'];
                            $data['description'] =  $request['files_descripcion'][$indice];
                            $data['dependencia'] =  $tramite_data->tipoTramite->dependencia->description;

                            $fileController->uploadbase64($data);
                        }
                    }


                    $list_tramites_id[] = $tramite_data['id'];
                    Log::info("Se ha almacenado un nuevo tramite", ["Modulo" => "Juventud:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "ID Tramite" => $tramite_data['id']]);
                }
            } else {
                // Se verifica que se haya enviado tipos de tramite
                DB::rollBack();
                Log::error("Por favor ingrese un tipo de tramite", ["Modulo" => "Juventud:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => "No se ha ingresado ninguno tramite."]);
                return response()->json(['message' => 'Por favor ingrese un tipo de tramite.'], 203);
            }
            DB::commit();
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', 'idTramites' => $list_tramites_id], 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar el tramite", ["Modulo" => "Juventud:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }

    //edit
    public function edit($id)
    {
        return Inertia::render(
            'Manager/Tramites/Juventud/Edit',
            [
                'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::all(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 13)->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::all(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'estadosCbj' => EstadoCbj::where('activo', true)->get(),
                'sedes' => Sede::all(),
                'escuelasPrimarias' => Escuela::where('primaria', true)->get(),
                'escuelasSecundarias' => Escuela::where('secundaria', true)->get(),
                'escuelasNocturnas' => Escuela::where('nocturna', true)->get(),
                'orientaciones' => OrientacionEscuela::where('activo', true)->get(),
                'escuelasTurnos' => EscuelaTurno::all(),
                'escuelasDependencias' => EscuelaDependencia::all(),
                'centrosSalud' => CentroSalud::where('activo', true)->get(),
                'estadosSalud' => EstadoSalud::where('activo', true)->get(),
                'tramite' => Tramite::where('id', $id)->with('contactos', 'familiares', 'cbi_data', 'persons', 'persons.address','persons.salud','persons.education','persons.contact','persons.social','persons.aditional', 'archivos', 'familiares.person', 'familiares.parentesco', 'contactos.person', 'contactos.parentesco', 'contactos.person.contact')->get()
            ]
        );
    }


    public function list()
    {
        $length = request('length');

        $result = Tramite::query();

        $result->where('dependencia_id', 13);


        if (request('name')) {
            $name = json_decode(request('name'));
            $result->whereIn('id', function ($sub) use ($name) {
                $sub->selectRaw('tramites.id')
                    ->from('tramites')
                    ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                    ->join('person', 'person.id', '=', 'person_tramite.person_id')
                    ->where('person.name', 'LIKE', '%' . $name . '%')
                    ->orWhere('person.lastname', 'LIKE', '%' . $name . '%');
            });
        }
        if (request('num_documento')) {
            $num_documento = json_decode(request('num_documento'));
            $result->whereIn('id', function ($sub) use ($num_documento) {
                $sub->selectRaw('tramites.id')
                    ->from('tramites')
                    ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                    ->join('person', 'person.id', '=', 'person_tramite.person_id')
                    ->where('person.num_documento', 'LIKE', '%' . $num_documento . '%');
            });
        }
        if (request('date')) {
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));

            $result->where('fecha', '>=', $from)
                ->where('fecha', '<', $to);
        }
        if (request('tipo_tramite_id')) {
            $tipo_tramite_id = json_decode(request('tipo_tramite_id'));
            $result->where('tipo_tramite_id', $tipo_tramite_id);
        }

        return  $result->orderBy("tramites.fecha", 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($tramite) => [
                'tramite'   => $tramite,
                'persons'   => $tramite->persons,
                'contact_data' => $tramite->persons[0]->contact,
                'rol_tramite' => $tramite->rol_tramite[0]['description'],
                'tipo_tramite' => $tramite->tipoTramite
            ]);
    }
}