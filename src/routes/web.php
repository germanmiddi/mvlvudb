<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\Tramite\TramiteController;
use App\Http\Controllers\Manager\Setting\SettingController;
use App\Http\Controllers\Manager\Tramites\Discapacidad\DiscapacidadController;

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Tramites

Route::get('/alta-tramites', [TramiteController::class, 'index'])
    ->name('alta-tramite')
    ->middleware('auth');

// Discapacidad
Route::get('/discapacidad', [DiscapacidadController::class, 'index'])
    ->name('discapacidad')
    ->middleware('auth');    

Route::get('/discapacidad/create', [DiscapacidadController::class, 'create'])
    ->name('discapacidad.create')
    ->middleware('auth');    