<?php

namespace App\Http\Controllers\Manager\Persons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Model
use App\Models\Manager\Person;
use App\Models\Manager\AditionalData;
use App\Models\Manager\ContactData;
use App\Models\Manager\ContactoEmergencia;
use App\Models\Manager\Familiar;
use App\Models\Manager\SaludData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonController extends Controller
{
        //index

        public function index()
        {

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
