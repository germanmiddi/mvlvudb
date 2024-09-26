<?php

namespace App\Http\Controllers\Manager\Boxes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

//Models
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\Person;

class PersonBoxesController extends Controller
{
    public function index(){
        return Inertia::render('Manager/Boxes/PersonPadron',
        [
            'localidades' => Localidad::all(),
            'barrios'   => Barrio::all(),
            'toast' => Session::get('toast')
        ]);
    }

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

}
