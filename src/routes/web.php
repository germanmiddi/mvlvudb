<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\Export\ExportController;
use App\Http\Controllers\Manager\Import\ImportController;
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
use App\Http\Controllers\Manager\Tramites\Entidad\EntidadController;
use App\Http\Controllers\Manager\Uploads\FileController;

use App\Http\Controllers\Manager\Masterdata\MasterdataController;
use App\Http\Controllers\Manager\Report\ReportController;
use App\Http\Controllers\Manager\Users\UserController;

use App\Http\Controllers\Manager\Tramites\Details\DetailController;
use Illuminate\Support\Facades\URL;


if (App::environment('production')) {
    URL::forceScheme('https');
}

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [DashboardController::class, 'getstatistics'])->name('dashboard.statistics');

    // Report
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/report/summary', [ReportController::class, 'summary'])->name('report.summary');

    
    // Printer PDF
    Route::get('/pdf/acusepdf/{tramite}', [PdfController::class, 'acusepdf'])->name('pdf.acusepdf');
    Route::get('/pdf/acuseobservacionespdf/{tramite}', [PdfController::class, 'acuseObservacionPdf'])->name('pdf.acuseobservacionpdf');
    
    // LOGS
    Route::get('/logs', [LogController::class, 'index'])->name('logs');  
    Route::get('/logs/listLast', [LogController::class, 'listLast'])->name('logs.listLast');    

    // Exportar
    Route::post('/export/tramitesExcel', [ExportController::class, 'exportTramiteExcel'])->name('export.tramitesExcel');
    Route::get('/export/tramitesCBIExcel', [ExportController::class, 'exportTramiteCBIExcel'])->name('export.ramitesCBIExcel');
    Route::post('/export/personsExcel', [ExportController::class, 'exportPersonsExcel'])->name('export.personsExcel');
    Route::post('/export/entidadesExcel', [ExportController::class, 'exportEntidadExcel'])->name('export.entidadExcel');
    Route::get('/export/templateDependencia/{id}', [ExportController::class, 'exportTemplateDependencia'])->name('export.templateDependencia');
    
    // IMPORTADOR
    Route::get('/import', [ImportController::class, 'index'])->name('import');  
    Route::post('/import/entidad', [ImportController::class, 'importEntidades'])->name('import.entidad');
    Route::post('/import/dependencia', [ImportController::class, 'importDependencias'])->name('import.dependencia');  
    Route::post('/import/estado', [ImportController::class, 'importEstados'])->name('import.estado');  
    Route::post('/import/personas', [ImportController::class, 'importPersonas'])->name('import.personas'); 
    Route::post('/import/files', [ImportController::class, 'importFiles'])->name('import.files');  
    Route::post('/import/cud', [ImportController::class, 'importCud'])->name('import.cud');
    Route::post('/import/updateResponsable', [ImportController::class, 'updateResponsable'])->name('import.updateResponsable'); 
    Route::post('/import/importCbiDev', [ImportController::class, 'importCbiDev'])->name('import.importCbiDev');  

    Route::post('/import/templateDependencia', [ImportController::class, 'templateDependencia'])->name('import.templateDependencia');

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
    // Route::get('/discapacidad/view/{id}', [DiscapacidadController::class, 'view'])->name('discapacidad.view');  
    Route::get('/discapacidad/edit/{id}', [DiscapacidadController::class, 'edit'])->name('discapacidad.edit');    
    Route::post('/discapacidad/store', [DiscapacidadController::class, 'store'])->name('discapacidad.store');   
    Route::post('/discapacidad/update/{id}', [DiscapacidadController::class, 'update'])->name('discapacidad.update');    
    Route::get('/discapacidad/list', [DiscapacidadController::class, 'list'])->name('discapacidad.list'); 

    // Person
    Route::get('/persons', [PersonController::class, 'index'])->name('persons'); 
    Route::get('/persons/tramites/{id}', [PersonController::class, 'tramitesByPerson'])->name('persons.tramites'); 
    Route::get('/persons/comments/{id}', [PersonController::class, 'comments'])->name('persons.comments'); 
    Route::put('/persons/comments/{id}', [PersonController::class, 'editComments'])->name('persons.editComments'); 
    Route::delete('/persons/comments/{id}', [PersonController::class, 'deleteComments'])->name('persons.deleteComments'); 
    Route::get('/persons/list', [PersonController::class, 'list'])->name('persons.list'); 
    Route::get('/persons/listTramites', [PersonController::class, 'listTramites'])->name('persons.listTramites'); 
    Route::get('/persons/edit/{id}', [PersonController::class, 'edit'])->name('persons.edit'); 
    Route::post('/persons/update/{id}', [PersonController::class, 'update'])->name('persons.update');  

    Route::get('/persons/getPersonDni/{dni}', [PersonController::class, 'getPersonDni'])->name('persons.getPersonDni');
    Route::post('/persons/destroyFamiliar/', [PersonController::class, 'destroyFamiliar'])->name('persons.destroyFamiliar');
    Route::post('/persons/addFamiliar/', [PersonController::class, 'addFamiliar'])->name('persons.addFamiliar');
    Route::post('/persons/updateFamiliar/', [PersonController::class, 'updateFamiliar'])->name('persons.updateFamiliar');
    Route::post('/persons/destroyContacto/', [PersonController::class, 'destroyContacto'])->name('persons.destroyContacto');
    Route::post('/persons/addContacto/', [PersonController::class, 'addContacto'])->name('persons.addContacto');
    Route::post('/persons/updateContacto/', [PersonController::class, 'updateContacto'])->name('persons.updateContacto');



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

    // Entidad
    Route::get('/entidad', [EntidadController::class, 'index'])->name('entidad');    
    Route::get('/entidad/create', [EntidadController::class, 'create'])->name('entidad.create');  
    Route::get('/entidad/edit/{id}', [EntidadController::class, 'edit'])->name('entidad.edit');    
    Route::post('/entidad/store', [EntidadController::class, 'store'])->name('entidad.store');   
    Route::post('/entidad/update/{id}', [EntidadController::class, 'update'])->name('entidad.update');
    Route::delete('/entidad/destroy/{id}', [EntidadController::class, 'destroy'])->name('entidad.destroy');    
    Route::get('/entidad/list', [EntidadController::class, 'list'])->name('entidad.list'); 
    Route::post('/entidad/destroy_autoridad/', [EntidadController::class, 'destroyAutoridad'])->name('entidad.destroyAutoridad');
    Route::post('/entidad/update_autoridad/', [EntidadController::class, 'updateAutoridad'])->name('entidad.updateAutoridad');
    Route::post('/entidad/add_autoridad/', [EntidadController::class, 'addAutoridad'])->name('entidad.addAutoridad');

    // Masterdata

    Route::get('/masterdata', [MasterdataController::class, 'index'])->name('masterdata');
    Route::get('/masterdata/get_tipo_tramite/{d}', [MasterdataController::class, 'get_tipo_tramite'])->name('masterdata.get_tipo_tramite');
    Route::post('/masterdata/store_tipo_tramite/', [MasterdataController::class, 'store_tipo_tramite'])->name('masterdata.store_tipo_tramite');     
    Route::post('/masterdata/update_tipo_tramite/', [MasterdataController::class, 'update_tipo_tramite'])->name('masterdata.update_tipo_tramite');     
    Route::post('/masterdata/hide_tipo_tramite/', [MasterdataController::class, 'hideTipoTramite'])->name('masterdata.hide_tipo_tramite');
    Route::post('/masterdata/destroy_tipo_tramite/', [MasterdataController::class, 'destroyTipoTramite'])->name('masterdata.destroy_tipo_tramite');

    Route::get('/masterdata/get_escuela/{d}', [MasterdataController::class, 'get_escuela'])->name('masterdata.get_escuela');
    Route::post('/masterdata/store_escuela/', [MasterdataController::class, 'store_escuela'])->name('masterdata.store_escuela');  
    Route::post('/masterdata/update_escuela/', [MasterdataController::class, 'update_escuela'])->name('masterdata.update_escuela');     
    Route::post('/masterdata/hide_escuela/', [MasterdataController::class, 'hide_escuela'])->name('masterdata.hide_escuela');

    Route::post('/masterdata/export_datos', [MasterdataController::class, 'export_datos'])->name('masterdata.exportDatos');
     
    // Users

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/list', [UserController::class, 'list'])->name('users.list');
    Route::get('/users/checkuser', [UserController::class, 'checkUser'])->name('users.checkUser');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');

    // Details View

    Route::get('/tramites/detalles/{id}', [DetailController::class, 'view'])->name('detail.view');
    Route::post('/detail/addcomment/', [DetailController::class, 'addComment'])->name('detail.addComment');
    Route::get('/detail/getcomments/{tramite}', [DetailController::class, 'getComments'])->name('detail.getComments');
    Route::post('/detail/changedependencia/', [DetailController::class, 'changeDependencia'])->name('detail.changeDependencia');
    Route::post('/detail/changeEstado/', [DetailController::class, 'changeEstado'])->name('detail.changeEstado');
    Route::post('/detail/changeAssigment/', [DetailController::class, 'changeAssigment'])->name('detail.changeAssigment');
    

});