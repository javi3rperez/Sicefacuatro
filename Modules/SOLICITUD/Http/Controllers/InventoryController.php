<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
  
    public function inventory_warehouseman()
    {
        $inventory = DB::select("
            SELECT 
                elements.image,
                elements.name, 
                inventories.stock, 
                warehouses.name as warehouse_name, 
                categories.name as category_name,
                inventories.id
            FROM inventories 
            INNER JOIN elements ON inventories.element_id = elements.id
            INNER JOIN productive_unit_warehouses ON inventories.productive_unit_warehouse_id = productive_unit_warehouses.id
            INNER JOIN warehouses ON productive_unit_warehouses.warehouse_id = warehouses.id
            INNER JOIN categories ON elements.category_id = categories.id
        ");

        // Convertir a colección de arrays asociativos
        $inventory = collect($inventory)->map(function($item) {
            return (array)$item;
        });

        return view('solicitud::warehouseman.inventory_store', compact('inventory'));
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
