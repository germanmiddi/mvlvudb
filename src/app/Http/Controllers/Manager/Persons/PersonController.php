<?php

namespace App\Http\Controllers\Manager\Persons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Model
use App\Models\Manager\Person;
use App\Models\Manager\AditionalData;
use App\Models\Manager\Familiar;
use App\Models\Manager\SaludData;
use Illuminate\Support\Facades\Auth;
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


}
