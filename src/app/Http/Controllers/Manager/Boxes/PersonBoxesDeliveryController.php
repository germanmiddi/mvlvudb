<?php

namespace App\Http\Controllers\Manager\Boxes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

//Models
use App\Models\Manager\Person;
class PersonBoxesDeliveryController extends Controller
{
    public function index(){
        return Inertia::render('Manager/Boxes/Delivery');
    }
}
