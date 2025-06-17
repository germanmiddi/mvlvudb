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

    public function index()
    {
        return Inertia::render('Manager/Settings/Index');

    }

    public function list()
    {

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

    public function update(Request $request)
    {
        try {
            Settings::updateOrCreate(
                [
                    'module' => $request->module,
                    'key' => $request->key
                ],
                [
                    'value' => $request->value,
                    'value2' => $request->value2 ?? null
                ]
            );
            return response()->json(['message' => 'Datos guardados correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar los datos'], 500);
        }
    }
}
