<?php
use Illuminate\Support\Facades\Route;
use Modules\SOLICITUD\Http\Controllers\InventoryController;

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
    
        
        
        Route::get('/solicitud/ILider/inventory', [InventoryController::class, 'inventory'])->name('solicitud.ILider.inventory');

});
});