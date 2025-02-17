<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\MilDias\MilDiasController;
use App\Http\Controllers\Manager\CentrosBarriales\InscripcionesCBIController;
use App\Http\Controllers\Manager\CentrosBarriales\InscripcionesCBJController;
use App\Http\Controllers\Manager\CentrosBarriales\LegajoController;
use App\Http\Controllers\Manager\CentrosBarriales\LegajosCBController;
use App\Http\Controllers\Manager\Export\ExportController;
use App\Http\Controllers\Manager\Import\ImportController;
use App\Http\Controllers\Manager\Logs\LogController;
use App\Http\Controllers\Manager\Masterdata\MasterdataController;
use App\Http\Controllers\Manager\Persons\PersonController;
use App\Http\Controllers\Manager\Report\ReportController;
//use App\Http\Controllers\Manager\Tramite\TramiteController;
use App\Http\Controllers\Manager\Tramites\Details\DetailController;
use App\Http\Controllers\Manager\Tramites\Discapacidad\DiscapacidadController;
use App\Http\Controllers\Manager\Tramites\Entidad\EntidadController;
use App\Http\Controllers\Manager\Tramites\Fortalecimiento\FortalecimientoController;
use App\Http\Controllers\Manager\Tramites\General\GeneralController;
use App\Http\Controllers\Manager\Tramites\Genero\GeneroController;
use App\Http\Controllers\Manager\Tramites\Habitat\HabitatController;
use App\Http\Controllers\Manager\Tramites\Infancia\InfanciaController;
use App\Http\Controllers\Manager\Tramites\Juventud\JuventudController;
use App\Http\Controllers\Manager\Tramites\Mayor\MayorController;
use App\Http\Controllers\Manager\Tramites\Ninez\NinezController;
use App\Http\Controllers\Manager\Tramites\Pdf\PdfController;
use App\Http\Controllers\Manager\Tramites\Promocion\PromocionController;
use App\Http\Controllers\Manager\Tramites\Vivienda\ViviendaController;
use App\Http\Controllers\Manager\Uploads\FileController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Manager\Users\UserController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\Boxes\PersonBoxesController;
use App\Http\Controllers\Manager\Boxes\PersonBoxesDeliveryController;

use App\Http\Controllers\Manager\Masterdata\FortalecimientoController as MasterdataFortalecimientoController;

if (App::environment('production')) {
    URL::forceScheme('https');
}

//import collections routes
require_once 'Collection/web.php';

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('estaditicas')->group(function () {
        Route::get('/tramites', [DashboardController::class, 'dashboardTramites'])->name('dashboard.tramites');
        Route::get('/cbj', [DashboardController::class, 'dashboardCBJ'])->name('dashboard.cbj');
        Route::get('/cbi', [DashboardController::class, 'dashboardCBI'])->name('dashboard.cbi');
    });

    // Report
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/report/summary', [ReportController::class, 'summary'])->name('report.summary');
    Route::post('/report/exportTramiteExcel', [ReportController::class, 'exportTramiteExcel'])->name('report.exportTramiteExcel');
    Route::post('/report/exportTest', [ReportController::class, 'exportTest'])->name('report.exportTest');
    Route::get('/report/exportTramiteCBIExcel', [ReportController::class, 'exportTramiteCBIExcel'])->name('report.exportTramiteCBIExcel');
    Route::post('/report/exportInscriptosCBExcel', [ReportController::class, 'exportInscriptosCBExcel'])->name('report.exportInscriptosCBExcel');
    Route::post('/report/exportPersonsExcel', [ReportController::class, 'exportPersonsExcel'])->name('report.exportPersonsExcel');
    Route::post('/report/exportEntidadExcel', [ReportController::class, 'exportEntidadExcel'])->name('report.exportEntidadExcel');


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
    Route::post('/import/importEscuelas', [ImportController::class, 'importEscuelas'])->name('import.importEscuelas');

    Route::post('/import/templateDependencia', [ImportController::class, 'templateDependencia'])->name('import.templateDependencia');
    Route::post('/import/infanciaCB', [ImportController::class, 'infanciaCB'])->name('import.infanciaCB');
    Route::post('/import/juventudCB', [ImportController::class, 'juventudCB'])->name('import.juventudCB');

    // Manejo de Archivos
    Route::get('/file/download/{id}', [FileController::class, 'downloadfile'])->name('file.download');
    Route::get('/file/download/{id}/legajo', [FileController::class, 'downloadfilelegajo'])->name('file.download.legajo');
    Route::get('/file/render/{id}/legajo', [FileController::class, 'renderfilelegajo'])->name('file.render.legajo');
    Route::post('/file/updoad', [FileController::class, 'uploadfile'])->name('file.upload');
    Route::delete('/file/delete/{id}', [FileController::class, 'deletefile'])->name('file.delete');

    // Tramites
    //Route::get('/alta-tramites', [TramiteController::class, 'index'])->name('alta-tramite');

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
    Route::prefix('masterdata')->group(function () {

        Route::get('/', [MasterdataController::class, 'index'])->name('masterdata');
        Route::get('/get_tipo_tramite/{d}', [MasterdataController::class, 'get_tipo_tramite'])->name('masterdata.get_tipo_tramite');
        Route::post('/store_tipo_tramite/', [MasterdataController::class, 'store_tipo_tramite'])->name('masterdata.store_tipo_tramite');
        Route::post('/update_tipo_tramite/', [MasterdataController::class, 'update_tipo_tramite'])->name('masterdata.update_tipo_tramite');
        Route::post('/hide_tipo_tramite/', [MasterdataController::class, 'hideTipoTramite'])->name('masterdata.hide_tipo_tramite');
        Route::post('/destroy_tipo_tramite/', [MasterdataController::class, 'destroyTipoTramite'])->name('masterdata.destroy_tipo_tramite');

        Route::get('/get_escuela/{d}', [MasterdataController::class, 'get_escuela'])->name('masterdata.get_escuela');
        Route::post('/store_escuela/', [MasterdataController::class, 'store_escuela'])->name('masterdata.store_escuela');
        Route::post('/update_escuela/', [MasterdataController::class, 'update_escuela'])->name('masterdata.update_escuela');
        Route::post('/hide_escuela/', [MasterdataController::class, 'hide_escuela'])->name('masterdata.hide_escuela');

        Route::get('/get_centro_salud', [MasterdataController::class, 'get_centroSalud'])->name('masterdata.get_centro_salud');
        Route::post('/store_centro_salud/', [MasterdataController::class, 'store_centroSalud'])->name('masterdata.store_centro_salud');
        Route::post('/update_centro_salud/', [MasterdataController::class, 'update_centroSalud'])->name('masterdata.update_centro_salud');
        Route::post('/hide_centro_salud/', [MasterdataController::class, 'hide_centroSalud'])->name('masterdata.hide_centro_salud');

        Route::post('/export_datos', [MasterdataController::class, 'export_datos'])->name('masterdata.exportDatos');

        Route::get('/centros-barriales/get-programas-sociales-cb', [MasterdataController::class, 'get_programas_sociales_cb'])->name('masterdata.centros_barriales.get_programas_sociales_cb');
        Route::post('/centros-barriales/store-programas-sociales-cb/', [MasterdataController::class, 'store_programa_social_cb'])->name('masterdata.centros_barriales.store_programas_sociales_cb');
        Route::post('/centros-barriales/update-programas-sociales-cb/', [MasterdataController::class, 'update_programa_social_cb'])->name('masterdata.centros_barriales.update_programas_sociales_cb');
        Route::post('/centros-barriales/hide-programas-sociales-cb/', [MasterdataController::class, 'hideProgramaSocialCB'])->name('masterdata.centros_barriales.hide_programas_sociales_cb');
        Route::post('/centros-barriales/destroy-programas-sociales-cbe/', [MasterdataController::class, 'destroyProgramasocialCB'])->name('masterdata.centros_barriales.destroy_programas_sociales_cb');

        Route::get('/centros-barriales/get-actividades-cb', [MasterdataController::class, 'get_actividades_cb'])->name('masterdata.centros_barriales.get_actividades_cb');
        Route::post('/centros-barriales/store-actividad_cb/', [MasterdataController::class, 'store_actividad_cb'])->name('masterdata.centros_barriales.store_actividad_cb');
        Route::post('/centros-barriales/update-actividad-cb/', [MasterdataController::class, 'update_actividad_cb'])->name('masterdata.centros_barriales.update_actividad_cb');
        Route::post('/centros-barriales/hide-actividad-cb/', [MasterdataController::class, 'hideActividadCB'])->name('masterdata.centros_barriales.hide_actividad_cb');
        Route::post('/centros-barriales/destroy-actividad-cbe/', [MasterdataController::class, 'destroyActividadCB'])->name('masterdata.centros_barriales.destroy_actividad_cb');

        Route::get('/centros-barriales/get-areas-legajo-cb', [MasterdataController::class, 'get_areas_legajo_cb'])->name('masterdata.centros_barriales.get_areas_legajo_cb');
        Route::post('/centros-barriales/store-areas-legajo-cb/', [MasterdataController::class, 'store_areas_legajo_cb'])->name('masterdata.centros_barriales.store_areas_legajo_cb');
        Route::post('/centros-barriales/update-areas-legajo-cb/', [MasterdataController::class, 'update_areas_legajo_cb'])->name('masterdata.centros_barriales.update_areas_legajo_cb');
        Route::post('/centros-barriales/hide-areas-legajo-cb/', [MasterdataController::class, 'hideAreaLegajoCB'])->name('masterdata.centros_barriales.hide_areas_legajo_cb');
        Route::post('/centros-barriales/destroy-areas-legajo-cbe/', [MasterdataController::class, 'destroyAreaLegajoCB'])->name('masterdata.centros_barriales.destroy_areas_legajo_cb');

        //PROGRAMAS SOCIALES GENERAL
        Route::get('/programas-sociales/get-programas-sociales', [MasterdataController::class, 'get_programaSocial'])->name('masterdata.programasSociales.get_programaSocial');
        Route::post('/programas-sociales/store-programas-sociales/', [MasterdataController::class, 'store_programaSocial'])->name('masterdata.programasSociales.store_programaSocial');
        Route::post('/programas-sociales/update-programas-sociales/', [MasterdataController::class, 'update_programaSocial'])->name('masterdata.programasSociales.update_programaSocial');
        Route::post('/programas-sociales/hide-programas-sociales/', [MasterdataController::class, 'hide_programaSocial'])->name('masterdata.programasSociales.hide_programaSocial');
        Route::post('/programas-sociales/destroy-programas-sociales/', [MasterdataController::class, 'destroy_programaSocial'])->name('masterdata.programasSociales.destroy_programaSocial');

        Route::get('/fortalecimiento/get-puntos-entrega', [MasterdataFortalecimientoController::class, 'get_puntos_entrega'])->name('masterdata.fortalecimiento.get_puntos_entrega');
        Route::post('/fortalecimiento/store-puntos-entrega/', [MasterdataFortalecimientoController::class, 'store_puntos_entrega'])->name('masterdata.fortalecimiento.store_puntos_entrega');
        Route::post('/fortalecimiento/update-puntos-entrega/', [MasterdataFortalecimientoController::class, 'update_puntos_entrega'])->name('masterdata.fortalecimiento.update_puntos_entrega');
        Route::post('/fortalecimiento/hide-puntos-entrega/', [MasterdataFortalecimientoController::class, 'hide_puntos_entrega'])->name('masterdata.fortalecimiento.hide_puntos_entrega');
        Route::post('/fortalecimiento/destroy-puntos-entrega/', [MasterdataFortalecimientoController::class, 'destroy_puntos_entrega'])->name('masterdata.fortalecimiento.destroy_puntos_entrega');

        Route::get('/fortalecimiento/get-productos', [MasterdataFortalecimientoController::class, 'get_productos'])->name('masterdata.fortalecimiento.get_productos');
        Route::post('/fortalecimiento/store-productos/', [MasterdataFortalecimientoController::class, 'store_productos'])->name('masterdata.fortalecimiento.store_productos');
        Route::post('/fortalecimiento/update-productos/', [MasterdataFortalecimientoController::class, 'update_productos'])->name('masterdata.fortalecimiento.update_productos');
        Route::post('/fortalecimiento/hide-productos/', [MasterdataFortalecimientoController::class, 'hide_productos'])->name('masterdata.fortalecimiento.hide_productos');
        Route::post('/fortalecimiento/destroy-productos/', [MasterdataFortalecimientoController::class, 'destroy_productos'])->name('masterdata.fortalecimiento.destroy_productos');


    });

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

    // Downloads
    Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads');

    Route::get('/downloads/getfieldsItems/{dependencia}', [DownloadController::class, 'getfieldsItems'])->name('downloads.fieldsItems');

    // Entrega de Cajas a Personas
    Route::get('/person-boxes', [PersonBoxesController::class, 'index'])->name('person.boxes');
    Route::get('/person-boxes-delivery', [PersonBoxesDeliveryController::class, 'index'])->name('person.boxes.delivery');

    // Routes Mil Dias

    Route::prefix('centros-barriales')->group(function () {
        // Rutas para Inscripción Centros Barriales Juventud
        Route::prefix('juventud')->group(function () {
            Route::get('/', [InscripcionesCBJController::class, 'index'])->name('inscripcionCBJ');
            Route::get('/inscripcion', [InscripcionesCBJController::class, 'create'])->name('inscripcionCBJ.create');
            Route::post('/inscripcion', [InscripcionesCBJController::class, 'store'])->name('inscripcionCBJ.store');
        });

        // Rutas para Inscripción Centros Barriales Infancia
        Route::prefix('infancia')->group(function () {
            Route::get('/', [InscripcionesCBIController::class, 'index'])->name('inscripcionCBI');
            Route::get('/inscripcion', [InscripcionesCBIController::class, 'create'])->name('inscripcionCBI.create');
            Route::post('/inscripcion', [InscripcionesCBIController::class, 'store'])->name('inscripcionCBI.store');

            Route::get('/cocinero/{id}', [InscripcionesCBIController::class, 'cocinero'])->name('inscripcionCBI.cocinero');
        });

        // Rutas para Legajos Centros Barriales
        Route::prefix('legajo')->group(function () {
            Route::get('/', [LegajosCBController::class, 'index'])->name('legajoCB');
            Route::get('/detail/{id}', [LegajosCBController::class, 'legajo'])->name('legajoCB.legajo');
            Route::get('/list', [LegajosCBController::class, 'list'])->name('legajoCB.list');
            Route::put('/update-estado/{id}', [LegajosCBController::class, 'update_estado'])->name('legajoCB.updateEstado');
            Route::put('/update-estado-programa/{id}', [LegajosCBController::class, 'update_estado_programa'])->name('legajoCB.updateEstadoPrograma');
            Route::put('/update-estado-actividad/{id}', [LegajosCBController::class, 'update_estado_actividad'])->name('legajoCB.updateEstadoActividad');

            Route::post('/store-programa-social', [LegajosCBController::class, 'store_programa_social'])->name('legajoCB.storeProgramaSocial');
            Route::post('/store-actividad', [LegajosCBController::class, 'store_actividad'])->name('legajoCB.storeActividad');
            Route::post('/store-intervencion', [LegajosCBController::class, 'store_intervencion'])->name('legajoCB.storeIntervencion');
            Route::post('/store-informe', [LegajosCBController::class, 'store_informe'])->name('legajoCB.storeInforme');
            Route::post('/store-pedagogia', [LegajosCBController::class, 'store_pedagogia'])->name('legajoCB.storePedagogia');
            Route::put('/update-informe', [LegajosCBController::class, 'update_informe'])->name('legajoCB.updateInforme');
            Route::put('/update-programa-intervencion', [LegajosCBController::class, 'update_programa_intervencion'])->name('legajoCB.updateProgramaIntervencion');
            Route::put('/update-pedagogia', [LegajosCBController::class, 'update_pedagogia'])->name('legajoCB.updatePedagogia');


            Route::delete('/delete-informe/{id}', [LegajosCBController::class, 'delete_informe'])->name('legajoCB.deleteInforme');
            Route::post('/store-archivo', [LegajosCBController::class, 'store_archivo'])->name('legajoCB.storeArchivo');
            Route::delete('/delete-archivo/{id}', [LegajosCBController::class, 'delete_archivo'])->name('legajoCB.deleteArchivo');
            Route::delete('/delete-programa-intervencion/{id}', [LegajosCBController::class, 'delete_programa_intervencion'])->name('legajoCB.deleteProgramaIntervencion');
            Route::delete('/delete-pedagogia/{id}', [LegajosCBController::class, 'delete_pedagogia'])->name('legajoCB.deletePedagogia');

            Route::put('/update-legajo', [LegajosCBController::class, 'update_legajo'])->name('legajoCB.updateLegajo');
            Route::put('/update-legajo-direccion', [LegajosCBController::class, 'update_legajoDireccion'])->name('legajoCB.updateLegajoDireccion');
            Route::put('/update-legajo-responsable', [LegajosCBController::class, 'update_legajoResponsable'])->name('legajoCB.updateLegajoResponsable');
            Route::put('/update-legajo-autorizaciones', [LegajosCBController::class, 'update_legajoAutorizaciones'])->name('legajoCB.updateLegajoAutorizaciones');
            Route::put('/update-legajo-salud', [LegajosCBController::class, 'update_legajoSalud'])->name('legajoCB.updateLegajoSalud');
            Route::put('/update-legajo-educacion', [LegajosCBController::class, 'update_legajoEducacion'])->name('legajoCB.updateLegajoEducacion');
            Route::put('/update-legajo-gabinete', [LegajosCBController::class, 'update_legajoGabinete'])->name('legajoCB.updateLegajoGabinete');
            Route::put('/update-legajo-pedagogia', [LegajosCBController::class, 'update_legajoPedagogia'])->name('legajoCB.updateLegajoPedagogia');
            Route::put('/update-legajo-emprendedor', [LegajosCBController::class, 'update_legajoEmprendedor'])->name('legajoCB.updateLegajoEmprendedor');
            Route::put('/update-legajo-titular', [LegajosCBController::class, 'update_legajoTitular'])->name('legajoCB.updateLegajoTitular');
            Route::put('/update-legajo-assigned', [LegajosCBController::class, 'update_assignedResponsable'])->name('legajoCB.assignedResponsable');

        });

        // Rutas para Gabinete
        Route::prefix('gabinete')->group(function () {
            Route::get('/', [MilDiasController::class, 'index'])->name('mil-dias');
            Route::get('/inscripcion', [MilDiasController::class, 'create'])->name('mil-dias.create');
            Route::post('/inscripcion', [MilDiasController::class, 'store'])->name('mil-dias.store');
        });
    });

    Route::get('/legajo/{id}', [LegajoController::class, 'index'])->name('legajo.index');

});
