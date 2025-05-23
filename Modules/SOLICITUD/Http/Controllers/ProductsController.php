<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('store.products', compact('products'));
    }

    public function products_warehouseman()
    {
        $products = [
        ['id' => 1, 'nombre' => 'Machete', 'descripcion' => 'Marca xx', 'categoria' => 10],
        ['id' => 2, 'nombre' => 'Martillo', 'descripcion' => 'Chato', 'categoria' => 15],
        ];
        
        return view('solicitud::warehouseman.products_store', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('solicitud::products.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Validation and storage logic here
        // Example:
        // $product = new Product();
        // $product->nombre = $request->nombre;
        // $product->descripcion = $request->descripcion;
        // $product->categoria = $request->categoria;
        // $product->save();
        
        return redirect()->route('products.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // Find product by ID and pass to view
        return view('solicitud::products.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // Find product by ID and pass to edit view
        return view('solicitud::products.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // Find product by ID and update
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Find product by ID and delete
        return redirect()->route('products.index');
    }

}