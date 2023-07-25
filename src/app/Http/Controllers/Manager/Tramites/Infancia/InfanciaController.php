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
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Escuela;
use App\Models\Manager\EstadoCbi;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\EstadoGabinete;
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
use App\Models\Manager\Sede;
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InfanciaController extends Controller
{
    //index

    public function index()
    {
        return Inertia::render('Manager/Tramites/Infancia/Index',
        [
            'tiposTramite' => TipoTramite::where('dependencia_id', 12)->get(),
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 12)->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::all(),
                'sedes' => Sede::all(),
                'estadosCbi' => EstadoCbi::all(),
                'estadosGabinete' => EstadoGabinete::all(),
                'escuelas' => Escuela::all()
            ]
        );
    }

    //store
   public function store(Request $request)
   {
        dd($request);
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
                    'num_documento' => $request['num_documento'],
                    'num_cuit' => $request['num_cuit'] ?? null
                ]
            );

            AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $request['cant_hijos'],
                    'tipo_vivienda_id' => $request['tipo_vivienda_id'],
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

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'beca' => $request['beca'],
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
    
                    // Tramites del Titular
                    $tramite_data = Tramite::Create(
                        [
                            'fecha' => date("Y-m-d ", strtotime($request['fecha'])),
                            'observacion' => $request['tramites_observacion'][$indice],
        
                            'canal_atencion_id' => $request['canal_atencion_id'],
                            'tipo_tramite_id' => $request['tramites_id'][$indice],
                            'dependencia_id' => $dependencia['dependencia_id']
                        ]
                    );

                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
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
                dd($th);
                DB::rollBack();
                Log::error("Se ha generado un error al momento de almacenar el tramite", ["Modulo" => "Infancia:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }

    //list
    public function list()
    {
        $length = request('length');
        
        $result = Tramite::query();

        $result->where('dependencia_id', 12);


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
