<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Request as Solicitud;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
{
    $record = Solicitud::with(['items:id,request_id,item_description,observation'])
        ->orderBy('request_date', 'desc')
        ->paginate(10);

    return view('solicitud::warehouseadmin.record_admin', compact('record'));
}


    public function record_warehouseadmin(Request $request)
{
    $query = Solicitud::select(
        'id',
        'accountable_name',
        'request_date',
        'status',
        'approved_by_name'
    )
    ->with(['items' => function ($q) {
        $q->select('id', 'request_id', 'observation'); // incluir 'observation'
    }]);

    //  Filtro por estado
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    //  Filtro por fecha exacta
    // Si el usuario envía una fecha, filtra los registros para mostrar solo los de esa fecha específica
    if ($request->filled('date')) {
        $query->whereDate('request_date', $request->date);
    }

    // Orden descendente por fecha con paginación
    $record = $query->orderBy('request_date', 'desc')->paginate(10);

    return view('solicitud::warehouseadmin.record_admin', [
        'record' => $record,
        'status_selected' => $request->status,
        'date_selected' => $request->date
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
