<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Modules\SICA\Entities\Person;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Request as Solicitud;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    // Agrega el parámetro Request $request aquí
    public function list_warehouseman(Request $request)
    {
        $query = Solicitud::with(['person', 'productiveUnitWarehouse', 'movementType'])
            ->where('status', 'approved') // Solo aprobadas
            ->orderBy('required_date', 'desc');
        
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }
        
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('request_date', $request->date);
        }
        
        $list = $query->get();

        return view('solicitud::warehouseman.list_store', compact('list'));
    }
    
public function list_warehouseadmin(Request $request)
{
    $query = Solicitud::query()
                ->select([
                    'id',
                    'name',
                    'program',
                    'created_at'
                ])
                ->orderBy('created_at', 'desc');

    // Filtro por fecha
    if ($request->filled('fecha')) {
        $query->whereDate('created_at', $request->fecha);
    }

    // Filtro por nombre (búsqueda parcial)
    if ($request->filled('nombre')) {
        $query->where('name', 'like', '%'.$request->nombre.'%');
    }

    $list = $query->paginate(10);

    return view('solicitud::warehouseadmin.list_admin', [
        'list' => $list,
        'fecha_seleccionada' => $request->fecha,
        'nombre_seleccionado' => $request->nombre
    ]);
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
    public function store(Request $request)
    {
        //
    }

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
}