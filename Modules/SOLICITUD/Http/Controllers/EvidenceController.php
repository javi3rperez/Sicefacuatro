<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Evidence;
use Illuminate\Support\Facades\DB;
use Modules\SICA\Entities\Category;
use Modules\SICA\Entities\Element;
use Illuminate\Support\Facades\Auth;

class EvidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('store.evidence', compact('evidence'));
    }

public function evidence_warehouseman(Request $request)
{
    $evidence = DB::table('evidences')
        ->leftJoin('categories', 'evidences.category_id', '=', 'categories.id')
        ->leftJoin('elements', 'evidences.element_id', '=', 'elements.id')
        ->select(
            'evidences.*',
            'categories.name as category_name',
            'elements.name as element_name'
        )
        ->when($request->input('category_id'), function ($query) use ($request) {
            return $query->where('evidences.category_id', $request->input('category_id'));
        })
        ->when($request->input('element_id'), function ($query) use ($request) {
            return $query->where('evidences.element_id', $request->input('element_id'));
        })
        ->orderBy('evidences.created_at', 'desc')
        ->paginate(10);

    $categories = Category::all(); // Obtener todas las categorías
    $elements = DB::table('elements')->get(); // Obtener todos los elementos

    return view('solicitud::warehouseman.evidence_store', compact('evidence', 'categories', 'elements'));
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
    // Validación de los datos
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'element_id' => 'required|exists:elements,id',
        'movement_type' => 'required|in:entry,exit',
        'amount' => 'required|integer|min:1',
        'evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'comments' => 'nullable|string|max:500',
    ]);

    try {
        // Procesar la imagen
        $imagePath = null;
        if ($request->hasFile('evidence')) {
            $image = $request->file('evidence');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('evidences', $imageName, 'public');
        }

        // Obtener el nombre del elemento
        $element = Element::find($request->element_id);

        // Obtener información del usuario autenticado
        $user = Auth::user();

        // Crear la evidencia sin el campo user_id que no existe en la tabla
        Evidence::create([
            'category_id' => $request->category_id,
            'element_id' => $request->element_id,
            'movement_type' => $request->movement_type,
            'quantity' => $request->amount,
            'evidence_path' => $imagePath,
            'comments' => $request->comments,
            'product_name' => $element->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('solicitud.store.evidence')
            ->with('success', 'Evidencia guardada exitosamente.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al guardar la evidencia: ' . $e->getMessage())
            ->withInput();
    }
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
