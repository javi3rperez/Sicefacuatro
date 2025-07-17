<?php
use Illuminate\Support\Facades\Route;
use Modules\SOLICITUD\Http\Controllers\InventoryController;
use Modules\SOLICITUD\Http\Controllers\RequestController;
use Modules\SOLICITUD\Http\Controllers\HistoryController;
use Modules\SOLICITUD\Http\Controllers\ProductsController;
use Modules\SOLICITUD\Http\Controllers\CategoriesController;
use Modules\SOLICITUD\Http\Controllers\ListController;
use Modules\SOLICITUD\Http\Controllers\LotsController;
use Modules\SOLICITUD\Http\Controllers\EvidenceController;

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
        // rutas para el rol de administrador 2.0
        Route::get('/admin/inventory', [InventoryController::class, 'inventory_admin'])->name('solicitud.admin.inventory');
        Route::get('/admin/list', [ListController::class, 'list_admin'])->name('solicitud.admin.list');
        Route::get('/admin/evidence', [EvidenceController::class, 'evidence_admin'])->name('solicitud.admin.evidence');
        Route::get('/admin/movements', [MovementsController::class, 'movements_admin'])->name('solicitud.admin.movements');


        Route::get('/instructor/welcome', 'SOLICITUDController@instructor')->name('solicitud.instructor.welcome');
    
        
        // INSTRUCTOR LIDER 
        Route::get('/leader/welcome', 'SOLICITUDController@leader')->name('solicitud.leader.welcome');
        Route::get('/leader/inventory', [InventoryController::class, 'inventory_leader'])->name('solicitud.leader.inventory');
        Route::get('/leader/request', [RequestController::class, 'create'])->name('solicitud.leader.create');
        Route::get('/leader/history', [HistoryController::class, 'index'])->name('solicitud.leader.index');


        // ALMACENISTA
        Route::get('/store/welcome', 'SOLICITUDController@store')->name('solicitud.store.welcome');
        Route::get('/warehouseman/inventory', [InventoryController::class, 'inventory_warehouseman'])->name('solicitud.store.inventory');
        Route::get('/warehouseman/list', [ListController::class, 'list_warehouseman'])->name('solicitud.store.list');
        Route::get('/warehouseman/evidence', [EvidenceController::class, 'evidence_warehouseman'])->name('solicitud.store.evidence');
        Route::get('/warehouseman/movements', [InventoryController::class, 'movements_warehouseman'])->name('solicitud.store.movements');
            
});
});