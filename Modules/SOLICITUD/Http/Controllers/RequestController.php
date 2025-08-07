<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Request as Solicitud; // ✅ ESTA LÍNEA ES CLAVE

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index( Request $request)
{
    $estado = $request->input('estado');

    $query = Solicitud::query();

    if ($estado) {
        $query->where('estado', $estado);
    }

    $solicitudes = $query->orderBy('created_at', 'desc')->get();

    return view('solicitud::leader.history', compact('solicitudes', 'estado'));
}


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('solicitud::leader.request');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'program' => 'required|string|max:255',
        'batch' => 'required|string|max:255',
        'product' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'date' => 'required|date'
    ]);

    Solicitud::create($validated);

    return redirect()->back()->with('success', 'Solicitud enviada correctamente.');
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
    $solicitud = Solicitud::findOrFail($id);

    $solicitud->update([
        'producto' => $request->input('producto'),
        'cantidad' => $request->input('cantidad'),
        'estado'   => $request->input('estado'),
    ]);

    return redirect()->route('solicitud.leader.index')->with('success', 'Solicitud actualizada correctamente.');
}

public function destroy($id)
{
    $solicitud = Solicitud::findOrFail($id);
    $solicitud->delete();

    return redirect()->route('solicitud.leader.index')->with('success', 'Solicitud eliminada correctamente.');
}
}
