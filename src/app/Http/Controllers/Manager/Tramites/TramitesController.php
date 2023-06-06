<?php

namespace App\Http\Controllers\Manager\Tramites;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TramitesController extends Controller
{   
    public function index(){
        // return Inertia::render('Manager/Tramites/Index');
    }

}