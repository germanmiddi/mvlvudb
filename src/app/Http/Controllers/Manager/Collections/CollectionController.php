<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;


use App\Models\User;
use App\Models\Manager\PuntoEntrega;
use App\Models\Manager\Person;
use App\Models\Manager\Product;
use App\Models\Manager\CajasEntrevista;
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
            // ->whereMonth('date', now()->month)
            ->get();
        return $collections;
    }

    public function padron()
    {
        return Inertia::render('Manager/Collections/Padron/List', [
            'sedes' => PuntoEntrega::all(),
            'entrevistadores' => User::whereHas('puntosEntrega')->get()
        ]);
    }

    public function padronList()
    {
        $length = 30;
        $entrevistas = CajasEntrevista::query();

        if (request('name')) {
            $name = request('name');
            $entrevistas->whereHas('person', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $name . '%');
            });
        }

        if (request('num_documento')) {
            $num_documento = request('num_documento');
            $entrevistas->whereHas('person', function ($query) use ($num_documento) {
                $query->where('num_documento', $num_documento);
            });
        }

        if (request('date')) {
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));

            $entrevistas->where('fecha', '>=', $from)
                ->where('fecha', '<', $to);
        }

        if (request('punto_entrega_id')) {
            $punto_entrega_id = request('punto_entrega_id');
            $entrevistas->where('puntos_entrega_id', $punto_entrega_id);
        }

        if (request('entrevistador_id')) {
            $entrevistador_id = request('entrevistador_id');
            $entrevistas->where('entrevistador_id', $entrevistador_id);
        }

        return $entrevistas
            ->where('status_id', 2)
            ->orderBy('fecha', 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn($entrevista) => [
                'id' => $entrevista->id,
                'fecha' => $entrevista->fecha,
                'person' => $entrevista->person->lastname . ', ' . $entrevista->person->name,
                'num_documento' => $entrevista->person->num_documento,
                'entrevistador' => $entrevista->entrevistador,
                'puntosEntrega' => $entrevista->puntosEntrega,

            ]);
    }

    public function puntosEntrega()
    {
        return Inertia::render('Manager/Collections/PuntosEntrega/Index');
    }

    public function entregas()
    {
        return Inertia::render(
            'Manager/Collections/Entregas/Index',
            [
                'puntosEntrega' => PuntoEntrega::all(),
                'products' => Product::all(),
                'users' => User::whereHas('puntosEntrega')->get()
            ]
        );
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
    public function destroyPersonal(Request $request)
    {
        //eliminar el personal (relacion)
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->puntosEntrega()->detach($request->punto_entrega_id);

        return response()->json(['message' => 'Personal data deleted successfully']);
    }

    public function getCollectionList()
    {

        $length = request('length');

        $collections = Collection::query();

        if (request('name')) {

            $name = request('name');
            //buscar por nombre o apellido
            $collections->whereHas('person', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $name . '%');
            });

        }
        // dd(request('num_documento'));
        if (request('num_documento')) {
            $num_documento = request('num_documento');
            // dd($num_documento);
            $collections->whereHas('person', function ($query) use ($num_documento) {
                $query->where('num_documento', $num_documento);
            });
        }

        if (request('date')) {
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));

            $collections->where('date', '>=', $from)
                ->where('date', '<', $to);
        }

        if (request('product_id')) {
            $product_id = request('product_id');
            $collections->where('product_id', $product_id);
        }

        if (request('punto_entrega_id')) {
            $punto_entrega_id = request('punto_entrega_id');
            $collections->where('punto_entrega_id', $punto_entrega_id);
        }

        if (request('entregado_por')) {
            $user_id = request('entregado_por');
            $collections->where('user_id', $user_id);
        }

        return $collections
            ->orderBy('date', 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn($collection) => [
                'id' => $collection->id,
                'date' => $collection->date,
                'person' => $collection->person->lastname . ', ' . $collection->person->name,
                'num_documento' => $collection->person->num_documento,
                'entregado_por' => $collection->user->name,
                'punto_entrega' => $collection->puntoEntrega->description,
                'producto' => $collection->product->name
            ]);
    }

    public function getPerson($documento)
    {
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


            $fullHistory = array_merge($history->toArray(), $person->collections->toArray());
            //sort by date descending
            usort($fullHistory, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            $lastDelivery = Collection::where('address', $address)
                ->where('person_id', '=', $person->id)
                ->orderBy('date', 'asc')
                ->first();


            //Validacion de entrega de Cajas por entrevista y ultima entrega
            $canGetBox = $this->canReceiveBox($person, $lastDelivery);

            $response = $fullHistory != []
                ? [
                    'person' => $person,
                    'history' => $fullHistory,
                    'canGetBox' => $canGetBox,
                    'message' => 'Datos Encontrados',
                    'status' => 200
                ]
                : [
                    'person' => $person,
                    'history' => $fullHistory,
                    'canGetBox' => $canGetBox,
                    'message' => 'No se encontró historial de entregas',
                    'status' => 204
                ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No se encontró ninguna persona con el documento proporcionado', 'status' => 404]);
        }
    }
    private function canReceiveBox($person, $lastDelivery)
    {
        //Primero comprobnar la entrevista
        $entrevista = CajasEntrevista::where('person_id', $person->id)->first();
        if (!$entrevista) {
            return ['status' => false, 'message' => 'No se encontró una entrevista registrada'];
        }

        if ($entrevista->status_id != 2) {
            return ['status' => false, 'message' => 'La entrevista no fue aprobada'];
        }

        //Luego los diasd e entrega
        if (!$lastDelivery) {
            return ['status' => true,];
        }

        $daysSinceLastDelivery = Carbon::parse($lastDelivery->date)->diffInDays(Carbon::now());
        $message = match ($daysSinceLastDelivery) {
            0 => "Última entrega realizada hace unas horas. Deben pasar 30 días desde la última entrega para activar esta opción.",
            1 => "Última entrega realizada hace 1 día. Deben pasar 30 días desde la última entrega para activar esta opción.",
            default => "Última entrega realizada hace $daysSinceLastDelivery días. Deben pasar 30 días desde la última entrega para activar esta opción."
        };

        return [
            'status' => $daysSinceLastDelivery >= 30,
            'message' => $message,
        ];
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

    public function productos()
    {
        return Inertia::render('Manager/Collections/Productos/Index');
    }
}
