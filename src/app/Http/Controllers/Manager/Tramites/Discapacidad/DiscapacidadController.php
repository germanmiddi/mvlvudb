<?php

namespace App\Http\Controllers\Manager\Tramites\Discapacidad;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DiscapacidadController extends Controller
{
    //index
    public function index(){
        return Inertia::render('Manager/Tramites/Discapacidad/Index');
    }
    //create
    public function create()
    {
        return Inertia::render('Manager/Tramites/Discapacidad/Create');
    }
    //store
    public function store(Request $request)
    {
        //
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
}
