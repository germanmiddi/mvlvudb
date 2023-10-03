<?php

namespace App\Http\Controllers\Manager\Tramites\Infancia;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Manager\Uploads\FileController;

//Models
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CbiData;
use App\Models\Manager\CentroSalud;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\ContactData;
use App\Models\Manager\ContactoEmergencia;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Escuela;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\EscuelaNivel;
use App\Models\Manager\EscuelaTurno;
use App\Models\Manager\EstadoCbi;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\EstadoGabinete;
use App\Models\Manager\EstadoSalud;
use App\Models\Manager\Familiar;
use App\Models\Manager\NivelEducativo;
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

class InfanciaController extends Controller
{
    protected $sedesAvailables = ['La Loma', 'El Ceibo', 'Habana', 'Las Flores', 'Sivori'];
    protected $FamiliarConviviente = ['Madre', 'Padre', 'Abuela/o', 'Adulto/a Responsable', 'Hermana/o Mayor de Edad', 'Tia/o', 'Madrastra/Padrastro', 'Pareja Conviviente', 'Hija/o Hijastro/a', 'Hermana/o Menor de Edad', 'Otro Familiar'];
    //index

    public function index()
    {
        return Inertia::render('Manager/Tramites/Infancia/Index',
        [
            'tiposTramite' => TipoTramite::where('dependencia_id', 12)->active()->get(),
            'estados' => TramiteEstado::all(),
            'toast' => Session::get('toast')
        ]);
    }

    //create
    public function create()
    {
        return Inertia::render('Manager/Tramites/Infancia/Create',
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 12)->active()->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::whereIn('description', $this->FamiliarConviviente)->get(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'estadosCbi' => EstadoCbi::all(),
                'estadosGabinete' => EstadoGabinete::all(),
                'escuelas' => Escuela::where('primaria', true)->where('dependencia_id',12)->get(),
                'escuelasInfante' => Escuela::where('infante', true)->where('dependencia_id',12)->get(),
                'escuelasDependencias' => EscuelaDependencia::all(),
                'escuelasNiveles' => EscuelaNivel::all(),
                'escuelasTurnos' => EscuelaTurno::all(),
                'centrosSalud' => CentroSalud::where('activo', true)->get(),
                'estadosSalud' => EstadoSalud::where('activo', true)->get(),
            ]
        );
    }

    //store
   public function store(Request $request)
   {
        //dd($request);
        DB::beginTransaction();
        try {
            /**
             * DATOS DEL TITULAR
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
                    'programa_social_id' => $request['programa_social_id']
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $request['nivel_educativo_id'],
                    'estado_educativo_id' => $request['estado_educativo_id']
                ]
            );

            // address_data

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

            // contact_data

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
            /**
             * FIN DATOS DEL TITULAR
             */

            /**
             * DATOS DEL NIÑO
             */

             $nino = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $request['nino_tipo_documento_id'],
                    'num_documento' => $request['nino_num_documento']
                ],
                [
                    'lastname' => $request['nino_lastname'],
                    'name' => $request['nino_name'],
                    'fecha_nac' => $request['nino_fecha_nac'],
                    'tipo_documento_id' => $request['nino_tipo_documento_id'],
                    'num_documento' => $request['nino_num_documento']
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'nivel_educativo_id' => $request['nino_nivel_educativo_id'],
                    'estado_educativo_id' => $request['nino_estado_educativo_id'],
                    'escuela_id' => $request['nino_escuela_id'],
                    'escuela_infante_id' => $request['nino_escuela_infante_id'],
                    'escuela_dependencia_id' => $request['nino_escuela_dependencia_id'],
                    'escuela_localidad_id' => $request['nino_escuela_localidad_id'],
                    'escuela_nivel_id' => $request['nino_escuela_nivel_id'],
                    'escuela_turno_id' => $request['nino_escuela_turno_id'],
                    'permanencia' => $request['nino_permanencia'],
                    'certificado_escolar' => $request['nino_certificado_escolar'],
                    'observacion' => $request['nino_observacion_educacion'],
                ]
            );

            // address_data

            AddressData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'calle' => $request['nino_calle'],
                    'number' => $request['nino_number'],
                    'piso' => $request['nino_piso'],
                    'dpto' => $request['nino_dpto'],
                    'latitude' => $request['nino_latitude'],
                    'longitude' => $request['nino_longitude'],
                    'google_address' => $request['nino_google_address'],
                    'pais_id' => $request['nino_pais_id'],
                    'localidad_id' => $request['nino_localidad_id'],
                    'barrio_id' => $request['nino_barrio_id'],

                ]
            );

            // contact_data

            ContactData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'phone' => $request['nino_phone'],
                    'celular' => $request['nino_celular'],
                    'email' => $request['nino_email']
                ]
            );

            // salud_data

            SaludData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'apto_medico' => $request['nino_apto_medico'],
                    'libreta_vacunacion' => $request['nino_libreta_vacunacion'],
                    'observacion' => $request['nino_observacion'],
                    'centro_salud_id' => $request['nino_centro_salud_id'],
                    'estado_salud_id' => $request['nino_estado_salud_id'],
                    'observacion' => $request['nino_observacion_salud'],
                ]
            );

            /**
             * FIN DATOS DEL NIÑO
             */

            $list_tramites_id = array();
            
            // tramite
            if($request['tramites_id'] != null){

                foreach ($request['tramites_id'] as $indice => $valor) {
                    
                    // Obtengo ID de la dependencia.
                    $dependencia = TipoTramite::where('id', $request['tramites_id'][$indice])->first();   
    
                    // Tramites del Titular
                    $tramite_data = Tramite::Create(
                        [
                            'fecha' => date("Y-m-d ", strtotime($request['fecha'])),
                            'observacion' => $request['tramites_observacion'][$indice],
        
                            'canal_atencion_id' => $request['canal_atencion_id'],
                            'tipo_tramite_id' => $request['tramites_id'][$indice],
                            'dependencia_id' => $dependencia['dependencia_id'],
                            'parentesco_id' => $request['parentesco_id'],
                            'sede_id' => $request['sede_id'],
                            'estado_id' => 1, // Estado Abierto
                        ]
                    );

                    CbiData::Create(
                        [
                            'anio_inicio' => $request['anio_inicio'],
                            'aut_firmada' => $request['aut_firmada'],
                            'aut_retirarse' => $request['aut_retirarse'],
                            'aut_uso_imagen' => $request['aut_uso_imagen'],
                            'act_varias' => $request['act_varias'],
                            'act_esporadicas' => $request['act_esporadicas'],
                            'comedor' => $request['comedor'],
                            'estado_cbi_id' => $request['estado_cbi_id'],
                            'estado_gabinete_id'  => $request['estado_gabinete_id'],
                            'tramite_id' => $tramite_data['id']
                        ]
                    );

                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
                    
                    $nino->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO

                    // Verifico si existe familiar asociado.
                  
                    if($request['familiar_id']){
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
                  
                    if($request['contacto_id']){
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
        
                    if($request['files'] != null){
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
                    Log::info("Se ha almacenado un nuevo tramite", ["Modulo" => "Infancia:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $tramite_data['id'] ]);
                }
            }else{
                // Se verifica que se haya enviado tipos de tramite
                DB::rollBack();
                Log::error("Por favor ingrese un tipo de tramite", ["Modulo" => "Infancia:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => "No se ha ingresado ninguno tramite."]);
                return response()->json(['message' => 'Por favor ingrese un tipo de tramite.'], 203);
            }
            DB::commit();
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', 'idTramites' => $list_tramites_id], 200);
        } catch (\Throwable $th) {
                //dd($th);
                DB::rollBack();
                Log::error("Se ha generado un error al momento de almacenar el tramite", ["Modulo" => "Infancia:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }

    //edit
    public function edit($id)
    {
        return Inertia::render(
            'Manager/Tramites/Infancia/Edit',
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 12)->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::whereIn('description', $this->FamiliarConviviente)->get(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'estadosCbi' => EstadoCbi::all(),
                'estadosGabinete' => EstadoGabinete::all(),
                'escuelas' => Escuela::where('primaria', true)->where('dependencia_id',12)->get(),
                'escuelasInfante' => Escuela::where('infante', true)->where('dependencia_id',12)->get(),
                'escuelasDependencias' => EscuelaDependencia::all(),
                'escuelasNiveles' => EscuelaNivel::all(),
                'escuelasTurnos' => EscuelaTurno::all(),
                'centrosSalud' => CentroSalud::where('activo', true)->get(),
                'estadosSalud' => EstadoSalud::where('activo', true)->get(),
                'tramite' => Tramite::where('id', $id)->with('contactos', 'familiares', 'cbi_data', 'persons', 'persons.address','persons.salud','persons.education','persons.contact','persons.social','persons.aditional', 'archivos', 'familiares.person', 'familiares.parentesco', 'contactos.person', 'contactos.parentesco', 'contactos.person.contact')->get()
            ]
        );
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
           
            Person::where('id',$request['person_id'])->update(
                [
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento'],
                    'lastname' => $request['lastname'],
                    'name' => $request['name'],
                    'fecha_nac' => $request['fecha_nac'],
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento']
                ]
            );

            AditionalData::where('person_id',$request['person_id'])->update(
                [
                    'cant_hijos' => $request['cant_hijos'],
                    'situacion_conyugal_id' => $request['situacion_conyugal_id']
                ]
            );

            SocialData::where('person_id', $request['person_id'])->update(
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'programa_social_id' => $request['programa_social_id']
                ]
            );

            EducationData::where('person_id', $request['person_id'])->update(
                [
                    'nivel_educativo_id' => $request['nivel_educativo_id'],
                    'estado_educativo_id' => $request['estado_educativo_id']
                ]
            );

            // address_data

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

            // contact_data

            ContactData::where('person_id', $request['person_id'])->update(
                [
                    'phone' => $request['phone'],
                    'celular' => $request['celular'],
                    'email' => $request['email']
                ]
            );

            /**
             * DATOS DEL NIÑO
             */

            Person::where('id', $request['nino_person_id'])->update(
                [
                    'lastname' => $request['nino_lastname'],
                    'name' => $request['nino_name'],
                    'fecha_nac' => $request['nino_fecha_nac'],
                    'tipo_documento_id' => $request['nino_tipo_documento_id'],
                    'num_documento' => $request['nino_num_documento']
                ]
            );

            EducationData::where('person_id', $request['nino_person_id'])->update(
                [
                    'nivel_educativo_id' => $request['nino_nivel_educativo_id'],
                    'estado_educativo_id' => $request['nino_estado_educativo_id'],
                    'escuela_id' => $request['nino_escuela_id'],
                    'escuela_infante_id' => $request['nino_escuela_infante_id'],
                    'escuela_dependencia_id' => $request['nino_escuela_dependencia_id'],
                    'escuela_localidad_id' => $request['nino_escuela_localidad_id'],
                    'escuela_nivel_id' => $request['nino_escuela_nivel_id'],
                    'escuela_turno_id' => $request['nino_escuela_turno_id'],
                    'permanencia' => $request['nino_permanencia'],
                    'certificado_escolar' => $request['nino_certificado_escolar'],
                    'observacion' => $request['nino_observacion_educacion'],
                ]
            );

            // address_data

            AddressData::where('person_id', $request['nino_person_id'])->update(
                [
                    'calle' => $request['nino_calle'],
                    'number' => $request['nino_number'],
                    'piso' => $request['nino_piso'],
                    'dpto' => $request['nino_dpto'],
                    /* 'latitude' => $request['nino_latitude'],
                    'longitude' => $request['nino_longitude'],
                    'google_address' => $request['nino_google_address'],
                    'pais_id' => $request['nino_pais_id'], */
                    'localidad_id' => $request['nino_localidad_id'],
                    /* 'barrio_id' => $request['nino_barrio_id'], */

                ]
            );

            // contact_data

            ContactData::where('person_id', $request['nino_person_id'])->update(
                [
                    'phone' => $request['nino_phone'],
                    'email' => $request['nino_email']
                ]
            );

            // salud_data

            SaludData::where('person_id', $request['nino_person_id'])->update(
                [
                    'apto_medico' => $request['nino_apto_medico'],
                    'libreta_vacunacion' => $request['nino_libreta_vacunacion'],
                    'observacion' => $request['nino_observacion'],
                    'centro_salud_id' => $request['nino_centro_salud_id'],
                    'estado_salud_id' => $request['nino_estado_salud_id'],
                    'observacion' => $request['nino_observacion_salud'],
                ]
            );

            /**
             * FIN DATOS DEL NIÑO
             */

              // Obtengo ID de la dependencia.
            $dependencia = TipoTramite::where('id', $request['tipo_tramite_id'])->first();   


            // tramite
            Tramite::where('id', $request['tramite_id'])->update(
                [
                    'fecha' => date("Y-m-d ", strtotime($request['fecha'])),
                    'observacion' => $request['observacion'],
                    'canal_atencion_id' => $request['canal_atencion_id'],
                    'tipo_tramite_id' => $request['tipo_tramite_id'],
                    'parentesco_id' => $request['parentesco_id'],
                    'dependencia_id' => $dependencia['dependencia_id'],
                    'sede_id' => $request['sede_id'],
                ]
            );

            CbiData::where('tramite_id', $request['tramite_id'])->update(
                [
                    'anio_inicio' => $request['anio_inicio'],
                    'aut_firmada' => $request['aut_firmada'],
                    'aut_retirarse' => $request['aut_retirarse'],
                    'aut_uso_imagen' => $request['aut_uso_imagen'],
                    'act_varias' => $request['act_varias'],
                    'act_esporadicas' => $request['act_esporadicas'],
                    'comedor' => $request['comedor'],
                    'estado_cbi_id' => $request['estado_cbi_id'],
                    'estado_gabinete_id'  => $request['estado_gabinete_id']
                ]
            );

            DB::commit();
            Log::info("Se ha actualizado un nuevo tramite", ["Modulo" => "Infancia:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['tramite_id'] ]);
            return response()->json(['message' => 'Se actualizado correctamente el tramite del usuario.', 'idTramite' => $request['tramite_id'] ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de actualizar el tramite", ["Modulo" => "Infancia:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }

    //list
    public function list()
    {
        $length = request('length');
        
        $result = Tramite::query();

        $result->where('dependencia_id', 12);


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
