<?php

namespace App\Http\Controllers\Manager;

// use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Manager\Entidad;
use App\Models\Manager\Tramite;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return  Inertia::render('Manager/Dashboard/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getstatistics(){

        $tramites = Tramite::select('dependencia_id', DB::raw('COUNT(*) as count'))
            ->groupBy('dependencia_id')
            ->get();
        $entidades = Entidad::count();
        $data['tramites'] = $tramites;
        $data['entidades'] = $entidades;
        return ($data);
    }

    // public function getstatisticsFiltered(){
    //     $roles_entidades = [
    //         [
    //             'id' => '2',
    //             'name' => 'DISCAPACIDAD',
    //             'rol' => '-DIS-',
    //         ],
    //         [
    //             'id' => '3',
    //             'name' => 'ENTIDADES INTERMEDIAS',
    //             'rol' => '-ENT-',
    //         ],
    //         [
    //             'id' => '5',
    //             'name' => 'FORTALECIMIENTO COMUNITARIO',
    //             'rol' => '-FOR-',
    //         ],
    //         [
    //             'id' => '6',
    //             'name' => 'GÉNERO Y DIVERSIDAD',
    //             'rol' => '-GEN-',
    //         ],
    //         [
    //             'id' => '7',
    //             'name' => 'HÁBITAT',
    //             'rol' => '-HAB-',
    //         ],
    //         [
    //             'id' => '8',
    //             'name' => 'NIÑEZ Y ADOLESCENCIA',
    //             'rol' => '-NIN-',
    //         ],
    //         [
    //             'id' => '10',
    //             'name' => 'VENTANILLA ÚNICA',
    //             'rol' => '-VU-',
    //         ],
    //         [
    //             'id' => '12',
    //             'name' => 'CENTROS BARRIALES INFANCIA',
    //             'rol' => '-CBI-',
    //         ],
    //         [
    //             'id' => '13',
    //             'name' => 'CENTROS BARRIALES JUVENTUD',
    //             'rol' => '-CBJ-',
    //         ],
    //         [
    //             'id' => '14',
    //             'name' => 'PERSONAS MAYORES',
    //             'rol' => '-PM-',
    //         ],
    //     ];


    //     $userGroups = session('userGroups');
        
    //     $filteredEntityIds = array_map(function ($userGroup) use ($roles_entidades) {
    //         $matchingRole = array_filter($roles_entidades, function ($roleEntidad) use ($userGroup) {
    //             return strpos($userGroup, $roleEntidad['rol']) !== false;
    //         });
        
    //         return $matchingRole ? reset($matchingRole)['id'] : null;
    //     }, $userGroups);

    //     $filteredEntityIds = array_filter($filteredEntityIds); // Remove null values
        

    //     $data = Tramite::whereIn('dependencia_id', $filteredEntityIds)
    //         ->select('dependencia_id', DB::raw('COUNT(*) as count'))
    //         ->groupBy('dependencia_id')
    //         ->get();
            
    //     return ($data);
    // }    


}

