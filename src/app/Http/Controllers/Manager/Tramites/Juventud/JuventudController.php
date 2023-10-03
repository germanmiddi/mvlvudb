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
use App\Models\Manager\TramiteEstado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JuventudController extends Controller
{
    protected $sedesAvailables = ['Munro','Villa Martelli', 'La Loma', 'El Ceibo'];
    protected $notFamiliares = ['Hermanastra/o Mayor de Edad',
                            'Hermana/o Mayor de Edad', 
                            'Adulto/a Responsable'
                        ];
    //index

    public function index()
    {
        return Inertia::render(
            'Manager/Tramites/Juventud/Index',
            [
                'tiposTramite' => TipoTramite::where('dependencia_id', 13)->active()->get(),
                'estados' => TramiteEstado::all(),
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 13)->active()->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::whereNotIn('description', $this->notFamiliares)->get(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'estadosCbj' => EstadoCbj::where('activo', true)->get(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'escuelasPrimarias' => Escuela::where('primaria', true)->whereNull('dependencia_id')->get(),
                'escuelasSecundarias' => Escuela::where('secundaria', true)->whereNull('dependencia_id')->get(),
                'escuelasNocturnas' => Escuela::where('nocturna', true)->whereNull('dependencia_id')->get(),
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
                    'num_documento' => $request['num_documento']
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

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'programa_social_id' => $request['programa_social_id'],
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

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $request['phone'],
                    'celular' => $request['celular'],
                    'email' => $request['email']
                ]
            );

            if ($request['beneficiario_control'] == 'false') {

                EducationData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'nivel_educativo_id' => $request['nivel_educativo_id'],
                        'estado_educativo_id' => $request['estado_educativo_id'],
                        'escuela_primaria_id' => $request['escuela_primaria_id'],
                        'escuela_secundaria_id' => $request['escuela_secundaria_id'],
                        'escuela_nocturna_id' => $request['escuela_nocturna_id'],
                        'orientacion_secundario_id' => $request['orientacion_secundario_id'],
                        'nivel_secundario_id' => $request['nivel_secundario_id'],
                        'turno_nocturno_id' => $request['turno_nocturno_id'],
                        'dependencia_nocturno_id' => $request['dependencia_nocturno_id'],
                        'terciario' => $request['terciario'],
                        'name_terciario' => $request['name_terciario'],
                        'carrera_terciario' => $request['carrera_terciario'],
                        'anio_terciario' => $request['anio_terciario'],
                        'universitario' => $request['universitario'],
                        'name_universitario' => $request['name_universitario'],
                        'carrera_universitario' => $request['carrera_universitario'],
                        'anio_universitario' => $request['anio_universitario']
                    ]
                );

                SaludData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'apto_medico' => $request['apto_medico'],
                        'libreta_vacunacion' => $request['libreta_vacunacion'],
                        'centro_salud_id' => $request['centro_salud_id'],
                        'estado_salud_id' => $request['estado_salud_id'],
                        'observacion' => $request['observacion_salud'],
                        'fecha_apto_medico' => $request['fecha_apto_medico'],
                        'electrocardiograma' => $request['electrocardiograma'],
                        'fecha_electrocardiograma' => $request['fecha_electrocardiograma'],
                        'medicacion' => $request['medicacion'],
                        'name_medicacion' => $request['name_medicacion'],
                        'dosis' => $request['dosis'],
                    ]
                );
            } else {
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
                        'num_documento' => $request['beneficiario_num_documento']
                    ]
                );

                ContactData::updateOrCreate(
                    [
                        'person_id' => $beneficiario->id
                    ],
                    [
                        'phone' => $request['beneficiario_phone'],
                        'celular' => $request['beneficiario_celular'],
                        'email' => $request['beneficiario_email']
                    ]
                );

                EducationData::updateOrCreate(
                    [
                        'person_id' => $beneficiario->id
                    ],
                    [
                        'nivel_educativo_id' => $request['nivel_educativo_id'],
                        'estado_educativo_id' => $request['estado_educativo_id'],
                        'escuela_primaria_id' => $request['escuela_primaria_id'],
                        'escuela_secundaria_id' => $request['escuela_secundaria_id'],
                        'escuela_nocturna_id' => $request['escuela_nocturna_id'],
                        'orientacion_secundario_id' => $request['orientacion_secundario_id'],
                        'nivel_secundario_id' => $request['nivel_secundario_id'],
                        'turno_nocturno_id' => $request['turno_nocturno_id'],
                        'dependencia_nocturno_id' => $request['dependencia_nocturno_id'],
                        'terciario' => $request['terciario'],
                        'name_terciario' => $request['name_terciario'],
                        'carrera_terciario' => $request['carrera_terciario'],
                        'anio_terciario' => $request['anio_terciario'],
                        'universitario' => $request['universitario'],
                        'name_universitario' => $request['name_universitario'],
                        'carrera_universitario' => $request['carrera_universitario'],
                        'anio_universitario' => $request['anio_universitario']
                    ]
                );

                SaludData::updateOrCreate(
                    [
                        'person_id' => $beneficiario->id
                    ],
                    [
                        'apto_medico' => $request['apto_medico'],
                        'libreta_vacunacion' => $request['libreta_vacunacion'],
                        'centro_salud_id' => $request['centro_salud_id'],
                        'estado_salud_id' => $request['estado_salud_id'],
                        'observacion' => $request['observacion_salud'],
                        'fecha_apto_medico' => $request['fecha_apto_medico'],
                        'electrocardiograma' => $request['electrocardiograma'],
                        'fecha_electrocardiograma' => $request['fecha_electrocardiograma'],
                        'medicacion' => $request['medicacion'],
                        'name_medicacion' => $request['name_medicacion'],
                        'dosis' => $request['dosis'],
                    ]
                );

                AddressData::updateOrCreate(
                    [
                        'person_id' => $beneficiario->id
                    ],
                    [
                        'calle' => $request['beneficiario_calle'],
                        'number' => $request['beneficiario_number'],
                        'piso' => $request['beneficiario_piso'],
                        'dpto' => $request['beneficiario_dpto'],
                        'pais_id' => $request['beneficiario_pais_id'],
                        'localidad_id' => $request['beneficiario_localidad_id'],
                        'barrio_id' => $request['beneficiario_barrio_id'],

                    ]
                );
            }

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
                            'sede_id' => $request['sede_id'],
                            'estado_id' => 1, // Estado Abierto
                        ]
                    );

                    CbjData::Create(
                        [
                            'anio_inicio' => $request['anio_inicio'],
                            'estado_cbj_id' => $request['estado_cbj_id'],
                            'comedor_id' => $request['comedor_id'],
                            'actividad_cbj_id' => $request['actividad_cbj_id'],
                            'apoyo_escolar' => $request['apoyo_escolar'],
                            'act_empleo' => $request['act_empleo'],
                            'acompanamiento_cbj_id'  => $request['acompanamiento_cbj_id'],
                            'aut_firmada' => $request['aut_firmada'],
                            'aut_retirarse' => $request['aut_retirarse'],
                            'aut_uso_imagen' => $request['aut_uso_imagen'],
                            'certificado_escolar' => $request['certificado_escolar'],
                            'tramite_id' => $tramite_data['id'],

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
                'parentescos' => Parentesco::whereNotIn('description', $this->notFamiliares)->get(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'estadosCbj' => EstadoCbj::where('activo', true)->get(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'escuelasPrimarias' => Escuela::where('primaria', true)->whereNull('dependencia_id')->get(),
                'escuelasSecundarias' => Escuela::where('secundaria', true)->whereNull('dependencia_id')->get(),
                'escuelasNocturnas' => Escuela::where('nocturna', true)->whereNull('dependencia_id')->get(),
                'orientaciones' => OrientacionEscuela::where('activo', true)->get(),
                'escuelasTurnos' => EscuelaTurno::all(),
                'escuelasDependencias' => EscuelaDependencia::all(),
                'centrosSalud' => CentroSalud::where('activo', true)->get(),
                'estadosSalud' => EstadoSalud::where('activo', true)->get(),
                'tramite' => Tramite::where('id', $id)->with('contactos', 'familiares', 'cbj_data', 'persons', 'persons.address', 'persons.salud', 'persons.education', 'persons.contact', 'persons.social', 'persons.aditional', 'archivos', 'familiares.person', 'familiares.parentesco', 'contactos.person', 'contactos.parentesco', 'contactos.person.contact')->get()
            ]
        );
    }

    public function update(Request $request)
    {
        //dd($request);
        DB::beginTransaction();
        try {

            /**
             * Datos Genericos del tramite.
             */

            Person::where('id', $request['person_id'])->update(
                [
                    'lastname' => $request['lastname'],
                    'name' => $request['name'],
                    'fecha_nac' => $request['fecha_nac'],
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento']
                ]
            );

            AddressData::where('person_id', $request['person_id'])->update(
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

            SocialData::where('person_id', $request['person_id'])->update(
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'programa_social_id' => $request['programa_social_id'],
                ]
            );

            AditionalData::where('person_id', $request['person_id'])->update(
                [
                    'cant_hijos' => $request['cant_hijos'],
                    'situacion_conyugal_id' => $request['situacion_conyugal_id']
                ]
            );

            ContactData::where('person_id', $request['person_id'])->update(
                [
                    'phone' => $request['phone'],
                    'celular' => $request['celular'],
                    'email' => $request['email']
                ]
            );

            if ($request['beneficiario_control'] == 'false') {

                EducationData::where('person_id', $request['person_id'])->update(
                    [
                        'nivel_educativo_id' => $request['nivel_educativo_id'],
                        'estado_educativo_id' => $request['estado_educativo_id'],
                        'escuela_primaria_id' => $request['escuela_primaria_id'],
                        'escuela_secundaria_id' => $request['escuela_secundaria_id'],
                        'escuela_nocturna_id' => $request['escuela_nocturna_id'],
                        'orientacion_secundario_id' => $request['orientacion_secundario_id'],
                        'nivel_secundario_id' => $request['nivel_secundario_id'],
                        'turno_nocturno_id' => $request['turno_nocturno_id'],
                        'dependencia_nocturno_id' => $request['dependencia_nocturno_id'],
                        'terciario' => $request['terciario'],
                        'name_terciario' => $request['name_terciario'],
                        'carrera_terciario' => $request['carrera_terciario'],
                        'anio_terciario' => $request['anio_terciario'],
                        'universitario' => $request['universitario'],
                        'name_universitario' => $request['name_universitario'],
                        'carrera_universitario' => $request['carrera_universitario'],
                        'anio_universitario' => $request['anio_universitario']
                    ]
                );

                SaludData::where('person_id', $request['person_id'])->update(
                    [
                        'apto_medico' => $request['apto_medico'],
                        'libreta_vacunacion' => $request['libreta_vacunacion'],
                        'centro_salud_id' => $request['centro_salud_id'],
                        'estado_salud_id' => $request['estado_salud_id'],
                        'observacion' => $request['observacion_salud'],
                        'fecha_apto_medico' => $request['fecha_apto_medico'],
                        'electrocardiograma' => $request['electrocardiograma'],
                        'fecha_electrocardiograma' => $request['fecha_electrocardiograma'],
                        'medicacion' => $request['medicacion'],
                        'name_medicacion' => $request['name_medicacion'],
                        'dosis' => $request['dosis'],
                    ]
                );
            } else {
                Person::where('id', $request['beneficiario_id'])->update(
                    [
                        'lastname' => $request['beneficiario_lastname'],
                        'name' => $request['beneficiario_name'],
                        'fecha_nac' => $request['beneficiario_fecha_nac'],
                        'tipo_documento_id' => $request['beneficiario_tipo_documento_id'],
                        'num_documento' => $request['beneficiario_num_documento']
                    ]
                );

                ContactData::where('person_id', $request['beneficiario_id'])->update(
                    [
                        'phone' => $request['beneficiario_phone'],
                        'celular' => $request['beneficiario_celular'],
                        'email' => $request['beneficiario_email']
                    ]
                );

                EducationData::where('person_id', $request['beneficiario_id'])->update(
                    [
                        'nivel_educativo_id' => $request['nivel_educativo_id'],
                        'estado_educativo_id' => $request['estado_educativo_id'],
                        'escuela_primaria_id' => $request['escuela_primaria_id'],
                        'escuela_secundaria_id' => $request['escuela_secundaria_id'],
                        'escuela_nocturna_id' => $request['escuela_nocturna_id'],
                        'orientacion_secundario_id' => $request['orientacion_secundario_id'],
                        'nivel_secundario_id' => $request['nivel_secundario_id'],
                        'turno_nocturno_id' => $request['turno_nocturno_id'],
                        'dependencia_nocturno_id' => $request['dependencia_nocturno_id'],
                        'terciario' => $request['terciario'],
                        'name_terciario' => $request['name_terciario'],
                        'carrera_terciario' => $request['carrera_terciario'],
                        'anio_terciario' => $request['anio_terciario'],
                        'universitario' => $request['universitario'],
                        'name_universitario' => $request['name_universitario'],
                        'carrera_universitario' => $request['carrera_universitario'],
                        'anio_universitario' => $request['anio_universitario']
                    ]
                );

                SaludData::where('person_id', $request['beneficiario_id'])->update(
                    [
                        'apto_medico' => $request['apto_medico'],
                        'libreta_vacunacion' => $request['libreta_vacunacion'],
                        'centro_salud_id' => $request['centro_salud_id'],
                        'estado_salud_id' => $request['estado_salud_id'],
                        'observacion' => $request['observacion_salud'],
                        'fecha_apto_medico' => $request['fecha_apto_medico'],
                        'electrocardiograma' => $request['electrocardiograma'],
                        'fecha_electrocardiograma' => $request['fecha_electrocardiograma'],
                        'medicacion' => $request['medicacion'],
                        'name_medicacion' => $request['name_medicacion'],
                        'dosis' => $request['dosis'],
                    ]
                );

                AddressData::where('person_id', $request['beneficiario_id'])->update(
                    [
                        'calle' => $request['beneficiario_calle'],
                        'number' => $request['beneficiario_number'],
                        'piso' => $request['beneficiario_piso'],
                        'dpto' => $request['beneficiario_dpto'],
                        'pais_id' => $request['beneficiario_pais_id'],
                        'localidad_id' => $request['beneficiario_localidad_id'],
                        'barrio_id' => $request['beneficiario_barrio_id'],

                    ]
                );
            }

            // Obtengo ID de la dependencia.
            $dependencia = TipoTramite::where('id', $request['tipo_tramite_id'])->first();
            // tramite
            Tramite::where('id', $request['tramite_id'])->update(
                [
                    'fecha' => date("Y-m-d ", strtotime($request['fecha'])),
                    'observacion' => $request['observacion'],
                    'canal_atencion_id' => $request['canal_atencion_id'],
                    'tipo_tramite_id' => $request['tipo_tramite_id'],
                    'dependencia_id' => $dependencia['dependencia_id'],
                    'sede_id' => $request['sede_id'],
                ]
            );

            CbjData::where('tramite_id', $request['tramite_id'])->update(
                [
                    'anio_inicio' => $request['anio_inicio'],
                    'estado_cbj_id' => $request['estado_cbj_id'],
                    'comedor_id' => $request['comedor_id'],
                    'actividad_cbj_id' => $request['actividad_cbj_id'],
                    'apoyo_escolar' => $request['apoyo_escolar'],
                    'act_empleo' => $request['act_empleo'],
                    'acompanamiento_cbj_id'  => $request['acompanamiento_cbj_id'],
                    'aut_firmada' => $request['aut_firmada'],
                    'aut_retirarse' => $request['aut_retirarse'],
                    'aut_uso_imagen' => $request['aut_uso_imagen'],
                    'certificado_escolar' => $request['certificado_escolar']

                ]
            );

            DB::commit();
            Log::info("Se ha actualizado un nuevo tramite", ["Modulo" => "Juventud:update", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "ID Tramite" => $request['tramite_id']]);
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', "ID Tramite" => $request['tramite_id']], 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar el tramite", ["Modulo" => "Juventud:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }

    public function list()
    {
        $length = request('length');

        $result = Tramite::query();

        $result->where('dependencia_id', 13);

        if(request('tramite_id')){
            $tramite_id = json_decode(request('tramite_id'));
            $result->where('id', $tramite_id);
        }

        if(request('name')){
            $name = json_decode(request('name'));  
            $result->whereIn('id', function ($sub) use($name) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.name', 'LIKE', '%'.$name.'%')
                            ->orWhere('person.lastname', 'LIKE', '%'.$name.'%');
                    });
        }
        if(request('num_documento')){
            $num_documento = json_decode(request('num_documento'));  
            $result->whereIn('id', function ($sub) use($num_documento) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.num_documento', 'LIKE', '%'.$num_documento.'%');
                    });
        }
        if(request('date')){
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1]))); 
                   
            $result->where('fecha','>=', $from)
                    ->where('fecha', '<', $to);
        }
        if(request('tipo_tramite_id')){
            $tipo_tramite_id = json_decode(request('tipo_tramite_id'));
            $result->where('tipo_tramite_id', $tipo_tramite_id);
        }

        if(request('estado_id')){
            $estado_id = json_decode(request('estado_id'));
            $result->where('estado_id', $estado_id);
        }

        if(request('assigned_me')){
            $result->where('assigned', Auth::user()->id);
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
