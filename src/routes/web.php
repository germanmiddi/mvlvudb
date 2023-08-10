<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\Logs\LogController;
use App\Http\Controllers\Manager\Persons\PersonController;
use App\Http\Controllers\Manager\Tramite\TramiteController;
use App\Http\Controllers\Manager\Tramites\Discapacidad\DiscapacidadController;
use App\Http\Controllers\Manager\Tramites\Habitat\HabitatController;
use App\Http\Controllers\Manager\Tramites\Fortalecimiento\FortalecimientoController;
use App\Http\Controllers\Manager\Tramites\Promocion\PromocionController;
use App\Http\Controllers\Manager\Tramites\General\GeneralController;
use App\Http\Controllers\Manager\Tramites\Mayor\MayorController;
use App\Http\Controllers\Manager\Tramites\Genero\GeneroController;
use App\Http\Controllers\Manager\Tramites\Ninez\NinezController;
use App\Http\Controllers\Manager\Tramites\Infancia\InfanciaController;
use App\Http\Controllers\Manager\Tramites\Juventud\JuventudController;
use App\Http\Controllers\Manager\Tramites\Pdf\PdfController;
use App\Http\Controllers\Manager\Tramites\Vivienda\ViviendaController;
use App\Http\Controllers\Manager\Uploads\FileController;

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [DashboardController::class, 'getstatistics'])->name('dashboard.statistics');

    // Printer PDF
    Route::get('/pdf/acusepdf/{tramite}', [PdfController::class, 'acusepdf'])->name('pdf.acusepdf');

    // LOGS
    Route::get('/logs', [LogController::class, 'index'])->name('logs');  
    Route::get('/logs/listLast', [LogController::class, 'listLast'])->name('logs.listLast');    

    // Manejo de Archivos
    Route::get('/file/download/{id}', [FileController::class, 'downloadfile'])->name('file.download');
    Route::post('/file/updoad', [FileController::class, 'uploadfile'])->name('file.upload');
    Route::delete('/file/delete/{id}', [FileController::class, 'deletefile'])->name('file.delete');
    
    // Tramites
    Route::get('/alta-tramites', [TramiteController::class, 'index'])->name('alta-tramite');

    // General
    Route::get('/general', [GeneralController::class, 'index'])->name('general');  
    Route::get('/general/list', [GeneralController::class, 'list'])->name('general.list');   
   
    // Discapacidad
    Route::get('/discapacidad', [DiscapacidadController::class, 'index'])->name('discapacidad');    
    Route::get('/discapacidad/create', [DiscapacidadController::class, 'create'])->name('discapacidad.create');  
    Route::get('/discapacidad/edit/{id}', [DiscapacidadController::class, 'edit'])->name('discapacidad.edit');    
    Route::post('/discapacidad/store', [DiscapacidadController::class, 'store'])->name('discapacidad.store');   
    Route::post('/discapacidad/update/{id}', [DiscapacidadController::class, 'update'])->name('discapacidad.update');    
    Route::get('/discapacidad/list', [DiscapacidadController::class, 'list'])->name('discapacidad.list'); 

    // Person
    Route::get('/persons/getPersonDni/{dni}', [PersonController::class, 'getPersonDni'])->name('persons.getPersonDni');

    // Genero
    Route::get('/genero', [GeneroController::class, 'index'])->name('genero');    
    Route::get('/genero/create', [GeneroController::class, 'create'])->name('genero.create');   
    Route::get('/genero/edit/{id}', [GeneroController::class, 'edit'])->name('genero.edit');   
    Route::post('/genero/store', [GeneroController::class, 'store'])->name('genero.store'); 
    Route::post('/genero/update/{id}', [GeneroController::class, 'update'])->name('genero.update');     
    Route::get('/genero/list', [GeneroController::class, 'list'])->name('genero.list'); 

    // Niñez y Adolescencia
    Route::get('/ninez', [NinezController::class, 'index'])->name('ninez');    
    Route::get('/ninez/create', [NinezController::class, 'create'])->name('ninez.create');   
    Route::get('/ninez/edit/{id}', [NinezController::class, 'edit'])->name('ninez.edit'); 
    Route::post('/ninez/store', [NinezController::class, 'store'])->name('ninez.store');    
    Route::post('/ninez/update/{id}', [NinezController::class, 'update'])->name('ninez.update');     
    Route::get('/ninez/list', [NinezController::class, 'list'])->name('ninez.list'); 

    // Fortalecimiento
    Route::get('/fortalecimiento', [FortalecimientoController::class, 'index'])->name('fortalecimiento');    
    Route::get('/fortalecimiento/create', [FortalecimientoController::class, 'create'])->name('fortalecimiento.create');  
    Route::get('/fortalecimiento/edit/{id}', [FortalecimientoController::class, 'edit'])->name('fortalecimiento.edit');    
    Route::post('/fortalecimiento/store', [FortalecimientoController::class, 'store'])->name('fortalecimiento.store');   
    Route::post('/fortalecimiento/update/{id}', [FortalecimientoController::class, 'update'])->name('fortalecimiento.update');    
    Route::get('/fortalecimiento/list', [FortalecimientoController::class, 'list'])->name('fortalecimiento.list'); 

    // Promocion
    Route::get('/promocion', [PromocionController::class, 'index'])->name('promocion');    
    Route::get('/promocion/create', [PromocionController::class, 'create'])->name('promocion.create');  
    Route::get('/promocion/edit/{id}', [PromocionController::class, 'edit'])->name('promocion.edit');    
    Route::post('/promocion/store', [PromocionController::class, 'store'])->name('promocion.store');   
    Route::post('/promocion/update/{id}', [PromocionController::class, 'update'])->name('promocion.update');    
    Route::get('/promocion/list', [PromocionController::class, 'list'])->name('promocion.list'); 

    // Promocion
    Route::get('/mayores', [MayorController::class, 'index'])->name('mayores');    
    Route::get('/mayores/create', [MayorController::class, 'create'])->name('mayores.create');  
    Route::get('/mayores/edit/{id}', [MayorController::class, 'edit'])->name('mayores.edit');    
    Route::post('/mayores/store', [MayorController::class, 'store'])->name('mayores.store');   
    Route::post('/mayores/update/{id}', [MayorController::class, 'update'])->name('mayores.update');    
    Route::get('/mayores/list', [MayorController::class, 'list'])->name('mayores.list'); 

    // Habitat
    Route::get('/habitat', [HabitatController::class, 'index'])->name('habitat');    
    Route::get('/habitat/create', [HabitatController::class, 'create'])->name('habitat.create');  
    Route::get('/habitat/edit/{id}', [HabitatController::class, 'edit'])->name('habitat.edit');    
    Route::post('/habitat/store', [HabitatController::class, 'store'])->name('habitat.store');   
    Route::post('/habitat/update/{id}', [HabitatController::class, 'update'])->name('habitat.update');    
    Route::get('/habitat/list', [HabitatController::class, 'list'])->name('habitat.list'); 
    
    // Infancia CBI
    Route::get('/infancia', [InfanciaController::class, 'index'])->name('infancia');    
    Route::get('/infancia/create', [InfanciaController::class, 'create'])->name('infancia.create');  
    Route::get('/infancia/edit/{id}', [InfanciaController::class, 'edit'])->name('infancia.edit');    
    Route::post('/infancia/store', [InfanciaController::class, 'store'])->name('infancia.store');   
    Route::post('/infancia/update/{id}', [InfanciaController::class, 'update'])->name('infancia.update');    
    Route::get('/infancia/list', [InfanciaController::class, 'list'])->name('infancia.list'); 

    // Infancia CBI
    Route::get('/juventud', [JuventudController::class, 'index'])->name('juventud');    
    Route::get('/juventud/create', [JuventudController::class, 'create'])->name('juventud.create');  
    Route::get('/juventud/edit/{id}', [JuventudController::class, 'edit'])->name('juventud.edit');    
    Route::post('/juventud/store', [JuventudController::class, 'store'])->name('juventud.store');   
    Route::post('/juventud/update/{id}', [JuventudController::class, 'update'])->name('juventud.update');    
    Route::get('/juventud/list', [JuventudController::class, 'list'])->name('juventud.list'); 

    // Vivienda
    Route::get('/vivienda', [ViviendaController::class, 'index'])->name('vivienda');    
    Route::get('/vivienda/create', [ViviendaController::class, 'create'])->name('vivienda.create');  
    Route::get('/vivienda/edit/{id}', [ViviendaController::class, 'edit'])->name('vivienda.edit');    
    Route::post('/vivienda/store', [ViviendaController::class, 'store'])->name('vivienda.store');   
    Route::post('/vivienda/update/{id}', [ViviendaController::class, 'update'])->name('vivienda.update');    
    Route::get('/vivienda/list', [ViviendaController::class, 'list'])->name('vivienda.list'); 
});