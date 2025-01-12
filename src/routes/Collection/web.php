<?php

use App\Http\Controllers\Manager\Collections\CollectionController;
use App\Http\Controllers\Manager\Collections\EntrevistasController;
use App\Http\Controllers\Manager\Collections\ImportController as EntrevistasImportController;

Route::middleware(['auth'])
    ->prefix('collections')
    ->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('collections.index');
        Route::get('/padron', [CollectionController::class, 'padron'])->name('collections.padron');
        Route::get('/entregas', [CollectionController::class, 'entregas'])->name('collections.entregas');
        Route::get('/puntos-entrega', [CollectionController::class, 'puntosEntrega'])->name('collections.puntosEntrega');
        Route::get('/puntos-entrega/statistics', [CollectionController::class, 'puntosEntregaStatistics'])->name('collections.puntosEntregaStatistics');
        
        Route::get('/productos', [CollectionController::class, 'productos'])->name('collections.productos');
        
        Route::get('/personal', [CollectionController::class, 'personal'])->name('collections.personal');
        Route::get('/list_personal_data', [CollectionController::class, 'listPersonalData'])->name('collections.list_personal_data');
        Route::get('/list_personal', [CollectionController::class, 'listPersonal'])->name('collections.list_personal');
        Route::post('/store_personal', [CollectionController::class, 'storePersonal'])->name('collections.store_personal');
        Route::get('/getStatistics', [CollectionController::class, 'getStatistics'])->name('collections.getStatistics');

        Route::get('/getPerson/{documento}', [CollectionController::class, 'getPerson'])->name('collections.getPerson');
        Route::get('/getCollectionsFormData', [CollectionController::class, 'getCollectionsFormData'])->name('collections.getCollectionsFormData');
        Route::post('/storeCollection', [CollectionController::class, 'storeCollection'])->name('collections.storeCollection');

        Route::get('/getCollectionList', [CollectionController::class, 'getCollectionList'])->name('collections.getCollectionList');

        Route::group(['prefix' => 'padron'], function () {
            Route::get('/list', [CollectionController::class, 'padronList'])->name('collections.padron.list');
        });

        Route::group(['prefix' => 'entrevistas'], function () {
            Route::get('/', [EntrevistasController::class, 'index'])->name('collections.entrevistas.index');
            Route::get('/create', [EntrevistasController::class, 'create'])->name('collections.entrevistas.create');
            Route::get('/list', [EntrevistasController::class, 'list'])->name('collections.entrevistas.list');
            Route::get('/edit/{id}', [EntrevistasController::class, 'edit'])->name('collections.entrevistas.edit');
            Route::get('/view/{id}', [EntrevistasController::class, 'view'])->name('collections.entrevistas.view');
            Route::post('/store', [EntrevistasController::class, 'store'])->name('collections.entrevistas.store');
            Route::post('/update/{id}', [EntrevistasController::class, 'update'])->name('collections.entrevistas.update');
            Route::delete('/delete/{id}', [EntrevistasController::class, 'delete'])->name('collections.entrevistas.delete');
            Route::post('/import', [EntrevistasImportController::class, 'importEntrevistas'])->name('collections.entrevistas.import');
        });
    });


