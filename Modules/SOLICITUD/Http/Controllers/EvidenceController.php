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
        'evidence' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048', //PERMITIR SOLO IMÁGENES Y PDF
        'comments' => 'nullable|string|max:500',
    ]);

   try {
        // 1) Guardar archivo en storage/app/public/evidences y obtener la ruta relativa
        // Inicializa la variable de ruta del archivo
        $filePath = null;
        // Si se subió un archivo de evidencia, lo almacena en la carpeta 'evidences' del disco 'public'
        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('evidences', $fileName, 'public'); // Ejemplo: "evidences/1699999999_archivo.png"
        }

        // 2) Obtener nombre del elemento
        // Busca el elemento relacionado usando el ID proporcionado
        $element = Element::find($request->element_id);

        // 3) Crear registro
        // Crea un nuevo registro de evidencia en la base de datos con los datos proporcionados y la ruta del archivo
        Evidence::create([
            'category_id'   => $request->category_id,
            'element_id'    => $request->element_id,
            'movement_type' => $request->movement_type,
            'quantity'      => $request->amount,
            'evidence_path' => $filePath, // Guarda la ruta del archivo subido
            'comments'      => $request->comments,
            'product_name'  => optional($element)->name, // Guarda el nombre del elemento si existe
        ]);


        // Redirige a la ruta de evidencia con mensaje de éxito
        return redirect()->route('solicitud.store.evidence')
            ->with('success', 'Evidencia guardada exitosamente.');

    } catch (\Exception $e) {
        // Si ocurre un error, regresa a la página anterior con mensaje de error y mantiene los datos ingresados
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
};