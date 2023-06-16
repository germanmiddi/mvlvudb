<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\Persons\PersonController;
use App\Http\Controllers\Manager\Tramite\TramiteController;
use App\Http\Controllers\Manager\Tramites\Discapacidad\DiscapacidadController;
use App\Http\Controllers\Manager\Tramites\Genero\GeneroController;
use App\Http\Controllers\Manager\Tramites\Ninez\NinezController;
use App\Http\Controllers\Manager\Tramites\Pdf\PdfController;

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Printer PDF
    Route::get('/pdf/acusepdf/{tramite}', [PdfController::class, 'acusepdf'])->name('pdf.acusepdf');
    
    // Tramites
    Route::get('/alta-tramites', [TramiteController::class, 'index'])->name('alta-tramite')->middleware('auth');
   
    // Discapacidad
    Route::get('/discapacidad', [DiscapacidadController::class, 'index'])->name('discapacidad');    
    Route::get('/discapacidad/create', [DiscapacidadController::class, 'create'])->name('discapacidad.create');    
    Route::post('/discapacidad/store', [DiscapacidadController::class, 'store'])->name('discapacidad.store');    
    Route::get('/discapacidad/list', [DiscapacidadController::class, 'list'])->name('discapacidad.list'); 

    // Person
    Route::get('/persons/getPersonDni/{dni}', [PersonController::class, 'getPersonDni'])->name('persons.getPersonDni');

    // Genero
    Route::get('/genero', [GeneroController::class, 'index'])->name('genero');    
    Route::get('/genero/create', [GeneroController::class, 'create'])->name('genero.create');    
    Route::post('/genero/store', [GeneroController::class, 'store'])->name('genero.store');    
    Route::get('/genero/list', [GeneroController::class, 'list'])->name('genero.list'); 

    // Niñez y Adolescencia
    Route::get('/ninez', [NinezController::class, 'index'])->name('ninez');    
    Route::get('/ninez/create', [NinezController::class, 'create'])->name('ninez.create');    
    Route::post('/ninez/store', [NinezController::class, 'store'])->name('ninez.store');    
    Route::get('/ninez/list', [NinezController::class, 'list'])->name('ninez.list'); 
});