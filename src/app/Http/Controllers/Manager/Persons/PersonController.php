<?php

namespace App\Http\Controllers\Manager\Persons;

use App\Http\Controllers\Controller;
use App\Models\Manager\AddressData;
use Illuminate\Http\Request;

//Model
use App\Models\Manager\Person;
use App\Models\Manager\AditionalData;
use App\Models\Manager\Barrio;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\ContactData;
use App\Models\Manager\ContactoEmergencia;
use App\Models\Manager\Cud;
use App\Models\Manager\Dependencia;
use App\Models\Manager\EducationData;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\Familiar;
use App\Models\Manager\Localidad;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\Pais;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\SaludData;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\SocialData;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoPension;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\TipoVivienda;
use App\Models\Manager\Tramite;
use App\Models\Manager\TramiteComment;
use App\Models\Manager\TramiteEstado;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Svg\Tag\Rect;

class PersonController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Persons/Index',
        [
            'localidades' => Localidad::all(),
            'barrios'   => Barrio::all(),
            'toast' => Session::get('toast')
        ]);
    }

    //list
    public function list()
    {
        $length = request('length');
        
        $result = Person::query();


        if(request('lastname')){
            $lastname = json_decode(request('lastname'));  
            $result->where('lastname', 'LIKE', '%'.$lastname.'%');
        }

        if(request('name')){
            $name = json_decode(request('name'));  
            $result->where('name', 'LIKE', '%'.$name.'%');
        }

        if(request('num_documento')){
            $num_documento = json_decode(request('num_documento'));  
            $result->where('num_documento', 'LIKE', '%'.$num_documento.'%');
        }

        if(request('localidad')){
            $localidad = json_decode(request('localidad'));  
            $result->whereIn('id', function ($sub) use($localidad) {
                        $sub->selectRaw('person.id')
                            ->from('person')
                            ->join('address_data', 'person.id', '=', 'address_data.person_id')
                            ->where('address_data.localidad_id', $localidad);
                    });
        }

        if(request('barrio')){
            $barrio = json_decode(request('barrio'));  
            $result->whereIn('id', function ($sub) use($barrio) {
                        $sub->selectRaw('person.id')
                            ->from('person')
                            ->join('address_data', 'person.id', '=', 'address_data.person_id')
                            ->where('address_data.barrio_id', $barrio);
                    });
        }

        return  $result->orderBy("person.id")
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($person) => [
                'id'    => $person->id,
                'lastname'   => $person->lastname,
                'name'   => $person->name,
                'num_documento'   => $person->num_documento,
                'fecha_nac' => Carbon::parse($person->fecha_nac)->format("d-m-Y"),
                'barrio' => $person->address[0]->barrio->description ?? null,
                'cant_tramites'  => $person->tramites->count()
            ]);
    }

    public function tramitesByPerson($id)
    {
        return Inertia::render('Manager/Persons/ListTramites',
        [
            'tiposTramite' => TipoTramite::active()->get(),
            'dependencias' => Dependencia::all(),
            'estados' => TramiteEstado::all(),
            'person' => Person::find($id),
            'toast' => Session::get('toast')
        ]);
    }

    public function comments($id)
    {
        $person = Person::find($id);
        $person->load([
            'contact',
            'tramites' => function ($query) {
                $query->orderBy('fecha', 'desc'); // Ordenar trámites por fecha de forma descendente
            },
            'tramites.dependencia',
            'tramites.assigned',
            'tramites.comments' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Ordenar comentarios por fecha de creación de forma ascendente
            },
            'tramites.archivos',
            'tramites.comments.dependencia',
            'tramites.comments.user'
        ]);

        // Formatear las fechas
        $person->tramites->map(function ($tramite) {
            $tramite->fecha = Carbon::parse($tramite->fecha)->format('d-m-Y'); // Formato personalizado
            $tramite->comments->map(function ($comment) {
                $comment->created_at_comment = Carbon::parse($comment->created_at)->format('d-m-Y H:i'); // Formato personalizado
                return $comment;
            });
            return $tramite;
        });


        return Inertia::render('Manager/Persons/Comments',
        [
            'person' => $person,
            'toast' => Session::get('toast')
        ]);
    }

    public function editComments($id, Request $request){
        DB::beginTransaction();
        
        try {
            TramiteComment::where('id',$id)->update(
                [
                    'content' => $request->content
                ]
            );
            DB::commit();
            return response()->json(['message' => 'Se actualizado correctamente el comentario del tramite.'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el tramite. Verifique los datos ingresados.'], 203);
        }
    }

    public function deleteComments($id){
        DB::beginTransaction();
        
        try {
            TramiteComment::where('id',$id)->update(
                [
                    'activo' => 0
                ]
            );

            DB::commit();
            return response()->json(['message' => 'Se eliminado correctamente el comentario del tramite.'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Se ha producido un error al momento de eliminar el tramite. Verifique los datos ingresados.'], 203);
        }
    }


    public function listTramites()
    {
        $length = request('length');
        
        $result = Tramite::query();

        if(request('dependencia_id')){
            $dependencia_id = json_decode(request('dependencia_id'));
            $result->where('dependencia_id', $dependencia_id);
        }

        if(request('person_id')){
            $person_id = json_decode(request('person_id'));  
            $result->whereIn('id', function ($sub) use($person_id) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.id',$person_id);
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
                'tipo_tramite' => $tramite->tipoTramite,
                'dependencia' => $tramite->dependencia
            ]);
    }

        //create
        public function create()
        {

        }
        //store
        public function store(Request $request)
        {
    
        }
        //show
        public function show($id)
        {
            //
        }
        //edit
        public function edit($id)
        {
            return Inertia::render('Manager/Persons/Edit',
                [
                    'paises' => Pais::all(),
                    'barrios' => Barrio::all(),
                    'localidades' => Localidad::all(),
                    'coberturasMedica' => CoberturaMedica::all(),
                    'estadosEducativo' => EstadoEducativo::all(),
                    'nivelesEducativo' => NivelEducativo::all(),
                    'tiposDocumento' => TipoDocumento::all(),
                    'tiposOcupacion' => TipoOcupacion::all(),
                    'tiposPension' => TipoPension::all(),
                    'tiposVivienda' => TipoVivienda::all(),
                    'situacionesConyugal' => SituacionConyugal::all(),
                    'programasSocial' => ProgramaSocial::all(),
                    'person' => Person::where('id', $id)->with('address','cud', 'contact', 'aditional', 'salud', 'social','education', 'cud')->first()
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
                        'num_documento' => $request['num_documento'],
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

                //cud
                Cud::where('person_id', $request['person_id'])->update(
                    [
                        'codigo' => $request['codigo'],
                        'diagnostico' => $request['diagnostico']
                    ]
                );

                
                DB::commit();
                Log::info("Se ha actualizado los datos de la Persona", ["Modulo" => "Persons:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Person" => $request['person_id'] ]);
                return response()->json(['message' => 'Se actualizado correctamente los datos de la persona.', 'idTramite' => $request['tramite_id'] ], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error("Se ha generado un error al momento de actualizar lso datos de la Persona", ["Modulo" => "Persons:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar lso datos de la persona. Verifique los datos ingresados.'], 203);
            }
        }
        //destroy
        public function destroy($id)
        {
            //
        }
        //getPersonDni
        public function getPersonDni($dni)
        {
            return  Person::where('num_documento', $dni)->with('contact', 'address', 'aditional', 'education', 'cud', 'social', 'salud')->orderBy("created_at", 'DESC')
            ->paginate(999)
            ->withQueryString()
            ->through(fn ($person) => [
                'person'   => $person
            ]);
        }

        public function destroyFamiliar(Request $request){
            $familiar = Familiar::find($request->id);
        
            if (!$familiar) {
                Log::error("No se ha encontrado el familiar que desea eliminar", ["Modulo" => "Person:destroyFamiliar","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => "Id no encontrado ".$request->id ]);
                return response()->json(['message' => 'Se ha producido un error al momento de eliminar el familiar.'], 203);
            }
            
            $familiar->delete();
            Log::error("Se ha eliminado correctamente el familiar", ["Modulo" => "Person:destroyFamiliar","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Familiar" => $request->id ]);
            return response()->json(['message' => 'Se ha eliminado correctamente el familiar'], 200);
        }

        public function addFamiliar(Request $request)
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
    
                $familiar = Familiar::create(
                    [
                        'person_id' => $person['id'],
                        'tramite_id' => $request['tramite_id'],
                        'parentesco_id' => $request['parentesco_id']
                    ]
                );
                DB::commit();
                Log::info("Se ha almacenado un nuevo familiar", ["Modulo" => "Person:addFamiliar","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['tramite_id'] ]);
                return response()->json(['message' => 'Se agregado correctamente el familiar al tramite.', 'familiar' => $familiar, 'person' => $familiar->person, 'parentesco' => $familiar->parentesco], 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                Log::error("Se ha generado un error al momento de almacenar el familiar", ["Modulo" => "Person:addFamiliar","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar el familiar. Verifique los datos ingresados.'], 203);
            }
        }

        public function updateFamiliar(Request $request)
        {
            DB::beginTransaction();
            try {
                Person::where('id',$request['person_id'])->update(
                    [
                        'lastname' => $request['lastname'],
                        'name' => $request['name'],
                    ]
                );
    
                Familiar::where('id',$request['familiar_id'])->update(
                    [
                        'parentesco_id' => $request['parentesco_id']
                    ]
                );
                DB::commit();
                Log::info("Se ha actualizado correctamente el familiar", ["Modulo" => "Person:updateFamiliar","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['familiar_id'] ]);
                return response()->json(['message' => 'Se actualizado correctamente el familiar.'], 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                Log::error("Se ha generado un error al momento de actualizar el familiar", ["Modulo" => "Person:updateFamiliar","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar el familiar. Verifique los datos ingresados.'], 203);
            }
        }


        /* CONTACTO DE EMERGENCIA */
        public function destroyContacto(Request $request){
            $contacto = ContactoEmergencia::find($request->id);
        
            if (!$contacto) {
                Log::error("No se ha encontrado el contacto de emergencia que desea eliminar", ["Modulo" => "Person:destroyContacto","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => "Id no encontrado ".$request->id ]);
                return response()->json(['message' => 'Se ha producido un error al momento de eliminar el Contacto de emergencia.'], 203);
            }
            
            $contacto->delete();
            Log::error("Se ha eliminado correctamente el contacto de emergencia", ["Modulo" => "Person:destroyContacto","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Contacto" => $request->id ]);
            return response()->json(['message' => 'Se ha eliminado correctamente el contacto de emergencia'], 200);
        }

        public function addContacto(Request $request)
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

                ContactData::updateOrCreate(
                    [
                        'person_id' => $request['person_id'],
                    ],
                    [
                        'person_id' => $request['person_id'],
                        'phone' => $request['phone'],
                    ]
                );
    
                $contacto = ContactoEmergencia::create(
                    [
                        'person_id' => $person['id'],
                        'tramite_id' => $request['tramite_id'],
                        'parentesco_id' => $request['parentesco_id']
                    ]
                );
                DB::commit();
                Log::info("Se ha almacenado un nuevo contacto de emergencia", ["Modulo" => "Person:addContacto","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['tramite_id'] ]);
                return response()->json(['message' => 'Se agregado correctamente el contacto de emergencia al tramite.', 'contacto' => $contacto, 'person' => $contacto->person, 'parentesco' => $contacto->parentesco, 'contactData' => $contacto->person->contact], 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                Log::error("Se ha generado un error al momento de almacenar el contacto de emergencia", ["Modulo" => "Person:addContacto","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar el contacto de emergencia. Verifique los datos ingresados.'], 203);
            }
        }

        public function updateContacto(Request $request)
        {
            DB::beginTransaction();
            try {
                Person::where('id',$request['person_id'])->update(
                    [
                        'lastname' => $request['lastname'],
                        'name' => $request['name'],
                    ]
                );

                ContactData::where('person_id',$request['person_id'])->update(
                    [
                        'phone' => $request['phone'],
                    ]
                );
    
                ContactoEmergencia::where('id',$request['contacto_id'])->update(
                    [
                        'parentesco_id' => $request['parentesco_id']
                    ]
                );
                DB::commit();
                Log::info("Se ha actualizado correctamente el contacto de emergencia", ["Modulo" => "Person:updateContacto","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['contacto_id'] ]);
                return response()->json(['message' => 'Se actualizado correctamente el contacto de emergencia.'], 200);
            } catch (\Throwable $th) {
                dd($th);
                DB::rollBack();
                Log::error("Se ha generado un error al momento de actualizar el contacto de emergencia", ["Modulo" => "Person:updateContacto","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
                return response()->json(['message' => 'Se ha producido un error al momento de actualizar el contacto de emergencia. Verifique los datos ingresados.'], 203);
            }
        }

}
