<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SOLICITUDController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('solicitud::index');
        
    }
    public function welcome()
    {
        return view('solicitud::welcome');
        
    }
    public function admin()
{
    $approved = \Modules\SOLICITUD\Entities\Request::where('status', 'approved')->count();
    $rejected = \Modules\SOLICITUD\Entities\Request::where('status', 'rejected')->count();
    $pending  = \Modules\SOLICITUD\Entities\Request::where('status', 'pending')->count();

    return view('solicitud::admin', compact('approved', 'rejected', 'pending'));
}

   public function store()
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
    
    // Debug: ver todos los tipos de movimiento disponibles
    $allMovementTypes = DB::table('movement_types')->get();
    \Log::info('Movement Types:', ['types' => $allMovementTypes]);
    
    // Obtener IDs
    $entradaTypeId = DB::table('movement_types')
        ->where('name', 'Movimiento Entrada')
        ->value('id');
    
    $internoTypeId = DB::table('movement_types')
        ->where('name', 'Movimiento Interno')
        ->value('id');
    
    \Log::info('Movement Type IDs:', [
        'entrada_id' => $entradaTypeId,
        'interno_id' => $internoTypeId
    ]);
    
    // Si no se encuentran, usar los primeros IDs disponibles
    if (!$entradaTypeId) $entradaTypeId = 1;
    if (!$internoTypeId) $internoTypeId = 2;
    
    // Resto del código igual...
    $entradasCount = DB::table('movements')
        ->where('movement_type_id', $entradaTypeId)
        ->whereMonth('registration_date', $currentMonth)
        ->whereYear('registration_date', $currentYear)
        ->count();
    
    $salidasCount = DB::table('movements')
        ->where('movement_type_id', $internoTypeId)
        ->whereMonth('registration_date', $currentMonth)
        ->whereYear('registration_date', $currentYear)
        ->count();
    
    // ... resto del código para las cantidades
    
    return view('solicitud::store', [
        'entradas' => (object)[
            'total_entradas' => $entradasCount,
            'total_items_entradas' => $entradasItems ?? 0
        ],
        'salidas' => (object)[
            'total_salidas' => $salidasCount,
            'total_items_salidas' => $salidasItems ?? 0
        ],
        'mes_actual' => Carbon::now()->locale('es')->monthName,
        'anio_actual' => $currentYear
    ]);
}

    public function instructor()
    {
        return view('solicitud::instructor');
    }
    
    public function leader()
      {
        return view('solicitud::leader');
        }
    

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('solicitud::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('solicitud::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('solicitud::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
};