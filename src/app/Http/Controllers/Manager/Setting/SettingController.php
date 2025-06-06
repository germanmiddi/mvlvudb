<?php

namespace App\Http\Controllers\Manager\Setting;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Manager\Settings;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return Inertia::render('Manager/Settings/Index');

    }

    public function list(){

        $query = Settings::query();

        if (request('module')) {
            $query->where('module', request('module'));

            if (request('key')) {
                $query->where('key', request('key'));
            }
        }

        $setting = $query->get();

        return response()->json($setting);
    }

    public function update(Request $request){

        if($request->id){

        $setting = Settings::find($request->id);
        $setting->value = $request->value;

        if($request->value2){
            $setting->value2 = $request->value2;
        }

        $setting->save();
        }else{
            $setting = new Settings();
            $setting->module = $request->module;
            $setting->key = $request->key;
            $setting->value = $request->value;
            $setting->value2 = $request->value2 ?? null;
            $setting->save();
        }
        return response()->json($setting);
    }
}
