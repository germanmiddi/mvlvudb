<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Manager\Dependencia;
use App\Models\Manager\ColumnExport;


class DownloadController extends Controller
{
    public function index(){

        $columnsExport = ColumnExport::all();
        $dependencies = Dependencia::where('activo', '=', 1)->get();

        return Inertia::render('Manager/Downloads/Index', ['dependencias' => $dependencies, 'columnsExport' => $columnsExport]);
    }
}
