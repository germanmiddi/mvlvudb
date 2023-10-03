<?php

namespace App\Http\Controllers\Manager\Tramites\Genero;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\Uploads\FileController;
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

//Models
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\EstadoEducativo;
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
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use App\Models\Manager\Category;
use App\Models\Manager\ModalidadAtencion;
use App\Models\Manager\TramiteEstado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class GeneroController extends Controller
{
    protected $notFamiliares = ['Hermanastra/o Mayor de Edad',
                            'Hermana/o Mayor de Edad', 
                            'Adulto/a Responsable'
                        ];
    //index

    public function index()
    {
        return Inertia::render('Manager/Tramites/Genero/Index',
        [
            'tiposTramite' => TipoTramite::where('dependencia_id', 6)->active()->get(),
            'estados' => TramiteEstado::all(),
            'toast' => Session::get('toast')
        ]);
    }
    //create
    public function create()
    {
        return Inertia::render(
            'Manager/Tramites/Genero/Create',
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 6)->active()->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::whereNotIn('description', $this->notFamiliares)->get(),
                'categories' => Category::where('dependencia_id', 6)->get(),
                'modalidadesAtencion' => ModalidadAtencion::all(),
            ]
        );
    }
    //store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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
             * Registro de Beneficiario
             */

             if ($request['beneficiario_control'] == 'true') {
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
                    ]
                );
    
                ContactData::updateOrCreate(
                    [
                        'person_id' => $beneficiario->id
                    ],
                    [
                        'phone' => $request['beneficiario_phone'],
                        'email' => $request['beneficiario_email']
                    ]
                );
    
            }


            /**
             * FIN Registro de Beneficiario
             */

            $list_tramites_id = array();

            // tramite
            if($request['tramites_id'] != null){

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
                            'estado_id' => 1, // Estado Abierto,
                            'modalidad_atencion_id' => $request['modalidad_atencion_id'],
                            'category_id' => $request['category_id'],
                        ]
                    );
                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]);
                    if (isset($beneficiario)) {
                        $beneficiario->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
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
                     Log::info("Se ha almacenado un nuevo tramite", ["Modulo" => "Genero:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $tramite_data['id'] ]);
                }
            }else{
                // Se verifica que se haya enviado tipos de tramite
                DB::rollBack();
                Log::error("Por favor ingrese un tipo de tramite", ["Modulo" => "Genero:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => "No se ha ingresado ninguno tramite."]);
                return response()->json(['message' => 'Por favor ingrese un tipo de tramite.'], 203);
            }
            DB::commit();
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', 'idTramites' => $list_tramites_id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar el tramite", ["Modulo" => "Genero:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }
    //show
    public function show($id)
    {
        //
    }
    //edit
    public function edit($id)
    {
        return Inertia::render(
            'Manager/Tramites/Genero/Edit',
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 6)->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::whereNotIn('description', $this->notFamiliares)->get(),
                'tramite' => Tramite::where('id', $id)->with('persons', 'persons.address', 'archivos')->get(),
                'categories' => Category::where('dependencia_id', 6)->get(),
                'modalidadesAtencion' => ModalidadAtencion::all(),
            ]
        );
    }
    //update
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
             * Registro de Beneficiario
             */

             if ($request['beneficiario_control'] == 'true') {
                Person::where('id',$request['beneficiario_id'])->update(
                    [
                        'tipo_documento_id' => $request['beneficiario_tipo_documento_id'],
                        'num_documento' => $request['beneficiario_num_documento'],
                        'lastname' => $request['beneficiario_lastname'],
                        'name' => $request['beneficiario_name'],
                        'fecha_nac' => $request['beneficiario_fecha_nac'],
                        'tipo_documento_id' => $request['beneficiario_tipo_documento_id'],
                        'num_documento' => $request['beneficiario_num_documento'],
                    ]
                );

                ContactData::where('person_id', $request['beneficiario_id'])->update(
                    [
                        'phone' => $request['beneficiario_phone'],
                        'email' => $request['beneficiario_email']
                    ]
                );
    
            }


            /**
             * FIN Registro de Beneficiario
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
                    'dependencia_id' => $dependencia['dependencia_id'],
                    'parentesco_id' => $request['parentesco_id'],
                    'modalidad_atencion_id' => $request['modalidad_atencion_id'],
                    'category_id' => $request['category_id'],
                ]
            );

            if ($request->hasFile('file')) {
                $fileController = new FileController;
                $data = [];
    
                $data['file'] = $request->file('file');
                $data['tramite_id'] =  $request['tramite_id'];
                $data['description'] =  $request['description_file']; 
                $data['dependencia'] =  $dependencia['description'];
                
                $fileController->upload($data );
            }

            DB::commit();
            Log::info("Se ha actualizado un nuevo tramite", ["Modulo" => "Genero:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['tramite_id'] ]);
            return response()->json(['message' => 'Se actualizado correctamente el tramite del usuario.', 'idTramite' => $request['tramite_id'] ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de actualizar el tramite", ["Modulo" => "Genero:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }
    //destroy
    public function destroy($id)
    {
        //
    }
    //list
    public function list()
    {
        $length = request('length');
        
        $result = Tramite::query();

        $result->where('dependencia_id', 6);

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

