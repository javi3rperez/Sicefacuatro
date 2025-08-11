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
    public function inventory_leader()
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

        return view('solicitud::leader.inventory', compact('inventory'));
    }

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
        
        // Nueva consulta para obtener las categorías
        $categories = DB::table('categories')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

        // Obtener almacenes
        $warehouses = DB::table('warehouses')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();
        // Convertir a colección de arrays asociativos
        $inventory = collect($inventory)->map(function($item) {
            return (array)$item;
        });

        return view('solicitud::warehouseman.inventory_store', compact('inventory', 'categories', 'warehouses'));
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
    // Crear el producto (Element)
    $element = new Element();
    $element->name = $request->name;
    $element->category_id = $request->category_id;
    
    if ($request->hasFile('image')) {
        $element->image = $request->file('image')->store('products', 'public');
    }
    
    $element->save();

    // Obtener la unidad productiva asociada al almacén
    $puWarehouse = ProductiveUnitWarehouse::where('warehouse_id', $request->warehouse_id)->first();

    // Crear registro en el inventario
    $inventory = new Inventory();
    $inventory->element_id = $element->id;
    $inventory->productive_unit_warehouse_id = $puWarehouse->id;
    $inventory->stock = $request->stock;
    $inventory->save();

    return redirect()->route('solicitud.warehouseman.inventory')
        ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
            $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // 1. Guardar la imagen si existe
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            // 2. Crear el elemento (producto)
            $element = Element::create([
                'name' => $validatedData['name'],
                'category_id' => $validatedData['category_id'],
                'image' => $imagePath,
                'description' => $request->input('description', null),
                'status' => 'active'
            ]);

            // 3. Obtener la unidad productiva asociada al almacén
            $productiveUnitWarehouse = ProductiveUnitWarehouse::where('warehouse_id', $validatedData['warehouse_id'])->first();

            if (!$productiveUnitWarehouse) {
                throw new \Exception('No se encontró la unidad productiva asociada a este almacén');
            }

            // 4. Crear el registro en el inventario
            Inventory::create([
                'element_id' => $element->id,
                'productive_unit_warehouse_id' => $productiveUnitWarehouse->id,
                'stock' => $validatedData['stock'],
                'minimum_stock' => $request->input('minimum_stock', 0),
                'status' => 'available'
            ]);

            DB::commit();

            return redirect()->route('solicitud.warehouseman.inventory')
                ->with('success', 'Producto creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()->withInput()
                ->with('error', 'Error al crear el producto: ' . $e->getMessage());
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

        public function movements_warehouseman()
    {

        return view('solicitud::warehouseman.movements_store');
    }
}

