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
use Illuminate\Support\Facades\Redirect;

class GeneroController extends Controller
{
    //index

    public function index()
    {
        return Inertia::render('Manager/Tramites/Genero/Index',
        [
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
                'tiposTramite' => TipoTramite::where('dependencia_id', 6)->get(),
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::all(),
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

            // Obtengo ID de la dependencia.
            $dependencia = TipoTramite::where('id', $request['tipo_tramite_id'])->first();            

            // tramite
            $tramite_data = Tramite::Create(
                [
                    'fecha' => date("Y-m-d ", strtotime($request['fecha'])),
                    'observacion' => $request['observacion'],

                    'canal_atencion_id' => $request['canal_atencion_id'],
                    'tipo_tramite_id' => $request['tipo_tramite_id'],
                    'dependencia_id' => $dependencia['dependencia_id']
                ]
            );

            $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]);

            if ($request->hasFile('file')) {
                $fileController = new FileController;
                $data = [];
    
                $data['file'] = $request->file('file');
                $data['tramite_id'] =  $tramite_data['id'];
                $data['description'] =  $request['description_file']; 
                $data['dependencia'] =  $tramite_data->tipoTramite->dependencia->description;
                
                $fileController->upload($data );
            }

            DB::commit();
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', 'idTramite' => $tramite_data['id']], 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json(['message' => 'Se ha producido un error al momento de registrar el tramite.'], 203);
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
        //
    }
    //update
    public function update(Request $request, $id)
    {
        //
    }
    //destroy
    public function destroy($id)
    {
        //
    }
    //list
    public function list()
    {
        $result = Tramite::query();

        $result->where('dependencia_id', 6);

        return  $result->orderBy("tramites.created_at", 'DESC')
            ->paginate(999)
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

