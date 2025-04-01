<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use App\Models\Manager\Entrevista;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Cajas\TemplateEntrevistasExport;
use App\Exports\Cajas\EntregasExport;

use App\Models\Manager\Product;
use App\Models\Manager\PuntoEntrega;
use App\Models\User;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\Pais;
use App\Models\Manager\TipoTenencia;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\TipoPension;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\CajasEntrevistasStatus;
use App\Models\Manager\Person;
use App\Models\Manager\Collection;
use App\Models\Manager\Localidad;
use App\Models\Manager\Barrio;
use Carbon\Carbon;


class ExportController extends Controller
{
    public function exportTemplateEntrevistas()
    {

        // SEDE_ID
        $puntosEntrega = PuntoEntrega::all()->map(function ($puntoEntrega) {
            return $puntoEntrega->id . '. ' . $puntoEntrega->description;
        });

        // ENTREVISTADOR
        $entrevistadores = User::whereHas('puntosEntrega')->get()->map(function ($entrevistador) {
            return $entrevistador->id . '. ' . $entrevistador->name;
        });

        // Tipo_Documento
        $tipoDocumento = TipoDocumento::all()->map(function ($tipoDocumento) {
            return $tipoDocumento->id . '. ' . $tipoDocumento->description;
        });


        // situacion_conyugal
        $situacionConyugal = SituacionConyugal::all()->map(function ($situacionConyugal) {
            return $situacionConyugal->id . '. ' . $situacionConyugal->description;
        });
        // Paises
        $paises = Pais::all()->map(function ($pais) {
            return $pais->id . '. ' . $pais->description;
        });

        // TENENCIA
        $tenencia = TipoTenencia::all()->map(function ($tenencia) {
            return $tenencia->id . '. ' . $tenencia->descripcion;
        });
        // ocupacion
        $ocupacion = TipoOcupacion::all()->map(function ($ocupacion) {
            return $ocupacion->id . '. ' . $ocupacion->description;
        });
        // cobertura_salud
        $coberturaMedica = CoberturaMedica::all()->map(function ($coberturaMedica) {
            return $coberturaMedica->id . '. ' . $coberturaMedica->description;
        });

        // pensiones
        $tipoPension = TipoPension::all()->map(function ($tipoPension) {
            return $tipoPension->id . '. ' . $tipoPension->description;
        });

        // SOCIAL PROGRAMA
        $programaSocial = ProgramaSocial::all()->map(function ($programaSocial) {
            return $programaSocial->id . '. ' . $programaSocial->description;
        });

        // nivel_ed_curso
        $nivelEducativo = NivelEducativo::all()->map(function ($nivelEducativo) {
            return $nivelEducativo->id . '. ' . $nivelEducativo->description;
        });


        // nivel_alcanzado
        $estadoEducativo = EstadoEducativo::all()->map(function ($estadoEducativo) {
            return $estadoEducativo->id . '. ' . $estadoEducativo->description;
        });


        $entrevistasStatus = CajasEntrevistasStatus::all()->map(function ($status) {
            return $status->id . '. ' . $status->nombre;
        });

        return Excel::download(
            new TemplateEntrevistasExport(
                $puntosEntrega,
                $entrevistadores,
                $tipoDocumento,
                $situacionConyugal,
                $paises,
                $tenencia,
                $ocupacion,
                $coberturaMedica,
                $tipoPension,
                $programaSocial,
                $nivelEducativo,
                $estadoEducativo,
                $entrevistasStatus
            ),
            'template_entrevistas.xlsx'
        );
    }

    public function exportEntregas(Request $request)
    {
        $localidades = Localidad::get();
        $barrios = Barrio::get();

        $values = [];

        $collectionQuery = Collection::with(['person', 'puntoEntrega', 'product', 'user'])
            ->select('collections.*'); // Select only needed columns

        // Filtros
        if (request('name')) {
            $name = request('name');
            $collectionQuery->whereHas('person', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $name . '%');
            });
        }

        if (request('num_documento')) {
            $num_documento = request('num_documento');
            $collectionQuery->whereHas('person', function ($query) use ($num_documento) {
                $query->where('num_documento', $num_documento);
            });
        }

        if (request('date')) {
            $date = request('date');
            $from = Carbon::parse($date[0])->toDateString();
            $to = Carbon::parse($date[1])->addDay()->toDateString();
            $collectionQuery->whereDate('date', '>=', $from)
                ->whereDate('date', '<', $to);
        }

        if (request('product_id')) {
            $collectionQuery->where('product_id', request('product_id'));
        }

        if (request('punto_entrega_id')) {
            $collectionQuery->where('punto_entrega_id', request('punto_entrega_id'));
        }

        if (request('entregado_por')) {
            $collectionQuery->where('user_id', request('entregado_por'));
        }

        // Get only the necessary persons for the collections
        $personIds = $collectionQuery->pluck('person_id')->unique();
        $persons = Person::with(['address', 'education', 'tipoDoc'])
            ->whereIn('id', $personIds)
            ->get();

        $titles = [
            'Persona',
            'DNI',
            'Dirección',
            'Fecha',
            'Punto de Entrega',
            'Producto',
            'Entregado Por',
        ];

        // Use chunking for collections
        $collections = collect();
        $collectionQuery->chunk(1000, function ($chunk) use (&$collections) {
            $collections = $collections->concat($chunk);
        });

        return Excel::download(
            new EntregasExport($values, $titles, $persons, $collections, $localidades, $barrios),
            'Entregas.xlsx'
        );
    }
}
