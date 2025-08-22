<?php
use Illuminate\Support\Facades\Route;
use Modules\SOLICITUD\Http\Controllers\InventoryController;
use Modules\SOLICITUD\Http\Controllers\RequestController;
use Modules\SOLICITUD\Http\Controllers\HistoryController;
use Modules\SOLICITUD\Http\Controllers\ProductsController;
use Modules\SOLICITUD\Http\Controllers\CategoriesController;
use Modules\SOLICITUD\Http\Controllers\ListadminController;
use Modules\SOLICITUD\Http\Controllers\ListController;
use Modules\SOLICITUD\Http\Controllers\LotsController;
use Modules\SOLICITUD\Http\Controllers\EvidenceController;
use Modules\SOLICITUD\Http\Controllers\RecordController;
use Modules\SOLICITUD\Http\Controllers\SOLICITUDController;
use Modules\SOLICITUD\Http\Controllers\InstructorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['lang'])->group(function(){
    Route::prefix('solicitud')->group(function() {
        Route::get('/index', 'SOLICITUDController@index')->name('cefa.solicitud.index');

        // Rutas para el rol de administrador
        Route::get('/admin/welcome', 'SOLICITUDController@admin')->name('solicitud.admin.welcome');


        Route::get('/instructor/welcome', 'SOLICITUDController@instructor')->name('solicitud.instructor.welcome');
    
        // INSTRUCTOR LIDER 
        Route::get('/leader/welcome', 'SOLICITUDController@leader')->name('solicitud.leader.welcome');
        Route::get('/leader/inventory', [InventoryController::class, 'inventory_leader'])->name('solicitud.leader.inventory');
        Route::get('/leader/request', [RequestController::class, 'create'])->name('solicitud.leader.create');
        Route::get('/leader/history', [RequestController::class, 'index'])->name('solicitud.leader.index');
        Route::post('/leader/store', [RequestController::class, 'store'])->name('solicitud.leader.store');
        Route::put('/leader/request/update/{id}', [RequestController::class, 'update'])->name('solicitud.leader.update');
        Route::delete('/leader/request/delete/{id}', [RequestController::class, 'destroy'])->name('solicitud.leader.destroy');



        // ALMACENISTA
        Route::get('/store/welcome', 'SOLICITUDController@store')->name('solicitud.store.welcome');
        //rutas inventario ALMACENISTA
        Route::get('/warehouseman/inventory', [InventoryController::class, 'inventory_warehouseman'])->name('solicitud.store.inventory');
        Route::post('/warehouseman/inventory/create', [InventoryController::class, 'store'])->name('solicitud.store.inventory.create');
        //rutas lista ALMACENISTA
        Route::get('/warehouseman/list', [ListController::class, 'list_warehouseman'])->name('solicitud.store.list');
        //rutas evidencia ALMACENISTA
        Route::get('/warehouseman/evidence', [EvidenceController::class, 'evidence_warehouseman'])->name('solicitud.store.evidence');
        Route::post('/warehouseman/evidence/create', [EvidenceController::class, 'evidence_warehouseman'])->name('solicitud.store.evidence.create');
        Route::post('/warehouseman/evidence/create', [EvidenceController::class, 'store'])->name('solicitud.store.evidence.create');
        //rutas movimientos ALMACENISTA
        Route::get('/warehouseman/movement', [InventoryController::class, 'movement_warehouseman'])->name('solicitud.store.movements');
        Route::post('/warehouseman/movement/create', [InventoryController::class, 'movement_salida_entrada'])->name('solicitud.store.movement.create');
        // Rutas para reportes PDF
        Route::post('/warehouseman/movement/report', [InventoryController::class, 'generateMovementReport'])->name('solicitud.report.movements');
        Route::post('/warehouseman/movement/report/download', [InventoryController::class, 'downloadMovementReport'])->name('solicitud.report.movements.download');

        //ADMIN CRUD
        Route::get('/warehouseadmin/list', [ListController::class, 'list_warehouseadmin'])->name('solicitud.admin.list');
        Route::get('/warehouseadmin/record', [RecordController::class, 'record_warehouseadmin'])->name('solicitud.admin.record');
        Route::get('/warehouseadmin/inventory', [InventoryController::class, 'inventory_warehouseadmin'])->name('solicitud.admin.inventory');
        Route::get('/warehouseadmin/reports', [ReportsController::class, 'reports_warehouseadmin'])->name('solicitud.admin.reports');

            
        //Instructor
        Route::get('/instructor/inventory', [InstructorController::class, 'inventory_instructor'])->name('solicitud.instructor.inventory');
        Route::get('/instructor/request', [InstructorController::class, 'request_instructor'])->name('solicitud.instructor.request');
        Route::get('/instructor/history', [InstructorController::class, 'history_instructor'])->name('solicitud.instructor.history');
        Route::post('/instructor/store', [InstructorController::class, 'store_instructor'])->name('solicitud.instructor.store');
    });
});