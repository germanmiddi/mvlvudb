<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Manager\PuntoEntrega;
use App\Models\Manager\Person;
use App\Models\Manager\Product;
class CollectionController extends Controller
{

    public function index()
    {
        // return Inertia::render('Manager/Collections/Index', [
        //     'collections' => Collection::all()
        // ]);
    }

    public function puntosEntregaStatistics()
    {
        //get the collections sumarized by punto entrega
        $collections = Collection::select('punto_entrega_id', DB::raw('count(id) as cantidad'))
            ->with('puntoEntrega')
            ->groupBy('punto_entrega_id')
            ->whereMonth('date', now()->month)
            ->get();
        return $collections;
    }


    public function padron()
    {
        return Inertia::render('Manager/Collections/Padron/Index');
    }

    public function puntosEntrega()
    {
        return Inertia::render('Manager/Collections/PuntosEntrega/Index');
    }

    public function entregas()
    {
        return Inertia::render('Manager/Collections/Entregas/Index');
    }

    public function personal()
    {
        return Inertia::render('Manager/Collections/Personal/Index');
    }

    public function listPersonalData()
    {
        //get just model with relation to punto entrega
        $users = User::all();
        $puntosEntrega = PuntoEntrega::all();
        return response()->json(['users' => $users, 'puntosEntrega' => $puntosEntrega]);
    }
    public function listPersonal()
    {
        //get just model with relation to punto entrega
        $puntosEntregaUsuario = User::whereHas('puntosEntrega')->with('puntosEntrega')->get();
        return $puntosEntregaUsuario;
    }
    public function storePersonal(Request $request)
    {
        //store the personal data
        // Encuentra el usuario y el punto de entrega
        $user = User::find($request->user_id);
        $puntoEntrega = PuntoEntrega::find($request->punto_entrega_id);

        // Asocia el punto de entrega al usuario
        $user->puntosEntrega()->attach($puntoEntrega->id);

        return response()->json(['message' => 'Personal data stored successfully']);
    }

    public function getCollectionList()
    {
        //get the collections list
        $collections = Collection::with('puntoEntrega')
                                ->with('product')
                                ->with('person')
                                ->get();
        return $collections;
    }
    public function getPerson($documento)
    {
        if ($documento) {
            $person = Person::where('num_documento', $documento)
                ->with(
                    'collections',
                    'address',
                    'address.localidad',
                    'address.barrio',
                    'collections.puntoEntrega',
                    'collections.product',
                    'collections.user'

                )
                ->first();
            if ($person) {
                $address = $person->address[0]->calle ? "calle:" . $person->address[0]->calle : '';
                $address .= $person->address[0]->number ? "num:" . $person->address[0]->number : '';
                $address .= $person->address[0]->piso ? "piso:" . $person->address[0]->piso : '';
                $address .= $person->address[0]->dpto ? "dpto:" . $person->address[0]->dpto : '';
                $address .= $person->address[0]->localidad_id ? "localidad:" . $person->address[0]->localidad_id : '';
                $address .= $person->address[0]->barrio_id ? "barrio:" . $person->address[0]->barrio_id : '';
                $address = str_replace(' ', '', $address);
                
                // dd($address);
                $history = Collection::where('address', $address)
                                    ->where('person_id', '!=', $person->id)
                                    ->with('puntoEntrega')
                                    ->with('product')
                                    ->with('user')
                                    ->with('person')
                                    ->orderBy('date', 'desc')
                                    ->get();
            }

            $fullHistory = array_merge($history->toArray(), $person->collections->toArray());
            //sort by date descending
            usort($fullHistory, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            return response()->json(['person' => $person, 'history' => $fullHistory]);
        } else {
            return response()->json(['message' => 'No se encontró ninguna persona con el documento proporcionado']);
        }
    }

    public function getCollectionsFormData()
    {
        //get puntos de entrega del user logueado
        $user = auth()->user();
        $puntosEntrega = $user->puntosEntrega;
        $products = Product::all();
        return response()->json(['puntosEntrega' => $puntosEntrega, 'products' => $products, 'user' => $user]);
    }

    public function storeCollection(Request $request)
    {
        //store the collection
        $collection = Collection::create([
            'person_id' => $request->person_id,
            'address' => $request->address,
            'punto_entrega_id' => $request->punto_entrega_id,
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id,

            'date' => now()->format('Y-m-d')
        ]);
        return response()->json(['message' => 'Collection stored successfully']);
    }


}
