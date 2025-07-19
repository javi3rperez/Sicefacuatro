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
        Route::get('/admin/welcome', 'SOLICITUDController@admin')->name('solicitud.admin.welcome');
        Route::get('/leader/welcome', 'SOLICITUDController@leader')->name('solicitud.leader.welcome');
        Route::get('/store/welcome', 'SOLICITUDController@store')->name('solicitud.store.welcome');
        Route::get('/instructor/welcome', 'SOLICITUDController@instructor')->name('solicitud.instructor.welcome');
    
        
        // INSTRUCTOR LIDER 
        Route::get('/leader/inventory', [InventoryController::class, 'inventory_leader'])->name('solicitud.leader.inventory');
        Route::get('/leader/request', [RequestController::class, 'create'])->name('solicitud.leader.create');
        Route::get('/leader/history', [HistoryController::class, 'index'])->name('solicitud.leader.index');
        Route::post('/leader/store', [RequestController::class, 'store'])->name('solicitud.leader.store');


        // ALMACENISTA
        Route::get('/warehouseman/inventory', [InventoryController::class, 'inventory_warehouseman'])->name('solicitud.store.inventory');
        Route::get('/warehouseman/products', [ProductsController::class, 'products_warehouseman'])->name('solicitud.store.products');
        Route::get('/warehouseman/categories', [CategoriesController::class, 'categories_warehouseman'])->name('solicitud.store.categories');
        Route::get('/warehouseman/list', [ListController::class, 'list_warehouseman'])->name('solicitud.store.list');
        Route::get('/warehouseman/lots', [LotsController::class, 'lots_warehouseman'])->name('solicitud.store.lots');
        Route::get('/warehouseman/evidence', [EvidenceController::class, 'evidence_warehouseman'])->name('solicitud.store.evidence');
            
        //Instructor
        
        Route::get('/instructor/inventory', [InstructorController::class, 'inventory_instructor'])->name('solicitud.instructor.inventory');
        Route::get('/instructor/request', [InstructorController::class, 'request_instructor'])->name('solicitud.instructor.request');
        Route::get('/instructor/history', [InstructorController::class, 'history_instructor'])->name('solicitud.instructor.history');
        Route::post('/instructor/store', [InstructorController::class, 'store_instructor'])->name('solicitud.instructor.store');
    

});
});