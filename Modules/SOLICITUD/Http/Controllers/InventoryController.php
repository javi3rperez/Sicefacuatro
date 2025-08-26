<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Modules\SICA\Entities\ProductiveUnit;
use Modules\SICA\Entities\ProductiveUnitWarehouse;
use Illuminate\Support\Facades\Log;
use Modules\SICA\Entities\Inventory;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\Movement;
use Barryvdh\DomPDF\Facade\Pdf; 
use Modules\SICA\Entities\MovementDetail;
use Modules\SICA\Entities\MovementResponsibility;

use Exception;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function inventory_leader()
    {
        //consulta sql
        //iner join para traer datos relacionados
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
        $productiveWarehouses = ProductiveUnitWarehouse::join('productive_units', 'productive_unit_warehouses.productive_unit_id', '=', 'productive_units.id')
        ->join('warehouses', 'productive_unit_warehouses.warehouse_id', '=', 'warehouses.id')
        ->select(
            'productive_unit_warehouses.id',
            'productive_units.name as productive_unit_name',
            'warehouses.name as warehouse_name'
        )
        ->get();
        
        $elements = DB::table('elements')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();
        
        // Convertir a colección de arrays asociativos
        $inventory = collect($inventory)->map(function($item) {
            return (array)$item;
        });

        return view('solicitud::warehouseman.inventory_store', compact('inventory', 'categories', 'productiveWarehouses', 'elements'));
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
            'productive_unit_warehouse_id' => 'required|exists:productive_unit_warehouses,id',
            'element_id' => 'required|exists:elements,id',
            'destination' => 'required|in:Producción,Formación',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'state' => 'required|in:Disponible,No disponible',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            // Intenta crear un nuevo registro de inventario con los datos validados
            $inventory = Inventory::create([
                'person_id' => auth()->id(), // ID del usuario autenticado
                'productive_unit_warehouse_id' => $validatedData['productive_unit_warehouse_id'], // ID de la unidad productiva-almacén
                'element_id' => $validatedData['element_id'], // ID del elemento/producto
                'destination' => $validatedData['destination'], // Destino (Producción o Formación)
                'description' => $validatedData['description'] ?? null, // Descripción opcional
                'price' => $validatedData['price'], // Precio del producto
                'amount' => $validatedData['amount'], // Cantidad ingresada
                'stock' => $validatedData['stock'], // Stock disponible
                'state' => $validatedData['state'], // Estado (Disponible o No disponible)
            ]);

            // Redirige a la ruta de inventario con mensaje de éxito
            return redirect()->route('solicitud.store.inventory')
                ->with('success', 'Producto creado exitosamente');

        } catch (\Exception $e) {
            // Si ocurre un error, lo registra en el log y retorna con mensaje de error
            Log::error('Error al crear inventario: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al crear: '.$e->getMessage());
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

    public function movement_warehouseman(Request $request)
    {
        $query = DB::table('movement_details as md')
            ->join('movements as m', 'md.movement_id', '=', 'm.id')
            ->join('movement_responsibilities as mr', 'm.id', '=', 'mr.movement_id')
            ->join('movement_types as mt', 'm.movement_type_id', '=', 'mt.id')
            ->join('people as p', 'mr.person_id', '=', 'p.id')
            ->join('inventories as i', 'md.inventory_id', '=', 'i.id')
            ->join('elements as e', 'i.element_id', '=', 'e.id')
            ->select(
                'e.name',
                'm.registration_date',
                'm.return_date',
                'mt.name as movement_type_name',
                'm.observation',
                'm.state as movement_state',
                'p.first_name',
                'p.first_last_name',
                'p.second_last_name',
                'md.amount',
                'mr.person_id'
            )
            ->whereIn('mt.name', ['Movimiento Entrada', 'Movimiento Interno']); // ← FILTRO PRINCIPAL AGREGADO

        // Aplicar filtros
        if ($request->filled('type')) {
            $query->where('mt.name', $request->type);
        }

        if ($request->filled('state')) {
            $query->where('m.state', $request->state);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('m.registration_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('m.registration_date', '<=', $request->end_date);
        }

        // FILTRO POR ELEMENTO/PRODUCTO
        if ($request->filled('element_id')) {
            $query->where('e.id', $request->element_id);
        }

        $movements = $query->orderBy('m.registration_date', 'desc')
                        ->paginate(15);

        // OBTENER ELEMENTOS Y RESPONSABLES PARA EL MODAL
        $elements = DB::table('elements')->select('id', 'name')->orderBy('name')->get();
        $responsibles = DB::table('people')->select('id', 'first_name', 'first_last_name', 'second_last_name')->orderBy('first_name')->get();

        return view('solicitud::warehouseman.movements_store', compact('movements', 'elements', 'responsibles'));
    }

    public function movement_salida_entrada(Request $request)
        {
        DB::beginTransaction();

        try {
            // ⿡ Guardar en movements
            $movement = Movement::create([
                'registration_date' => $request->registration_date,
                'movement_type_id' => $request->movement_type,  // ej. Movimiento Entrada
                'voucher_number'   => 0, // o genera consecutivo
                'price'            => 0,   // si aplica
                'observation'      => substr($request->observation, 0, 256),
                'state'            => 'Aprobado', // agregar formulario
            ]);

            // ⿢ Guardar en movement_details
            MovementDetail::create([
                'inventory_id' => $request->element_id,
                'amount'       => $request->amount,
                'price'=> '5000',//agregar formulario
                'created_at'   => now(),
                'updated_at'   => now(),
                'movement_id'  => $movement->id, // 🔑 relacionar
            ]);

            // ⿣ Guardar en movement_responsibilities
            MovementResponsibility::create([
                'movement_id' => $movement->id,
                'person_id'   => $request->responsible,
                'role'        => 'REGISTRO', // agregar formulario ejemplo, puedes setear dinámico
                'date'        => Carbon::now(),
                'created_at'  => now(),
            ]);

            DB::commit();

            return redirect()->route('solicitud.store.movements')
                ->with('success', 'Movimiento creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar movimiento',
                'error'   => $e->getMessage()
            ], 500);}
    }

    //documento pdf
    public function generateMovementReport(Request $request)
    {
        // Validar la fecha del reporte
        $validated = $request->validate([
            'report_date' => 'required|date',
            'report_type' => 'nullable|in:Movimiento Entrada,Movimiento Interno'
        ]);

        // Construir la consulta base
        $query = DB::table('movement_details as md')
            ->join('movements as m', 'md.movement_id', '=', 'm.id')
            ->join('movement_responsibilities as mr', 'm.id', '=', 'mr.movement_id')
            ->join('movement_types as mt', 'm.movement_type_id', '=', 'mt.id')
            ->join('people as p', 'mr.person_id', '=', 'p.id')
            ->join('inventories as i', 'md.inventory_id', '=', 'i.id')
            ->join('elements as e', 'i.element_id', '=', 'e.id')
            ->select(
                'e.name as product_name',
                'm.registration_date',
                'm.return_date',
                'mt.name as movement_type_name',
                'm.observation',
                'm.state as movement_state',
                'p.first_name',
                'p.first_last_name',
                'p.second_last_name',
                'md.amount',
                'mr.person_id'
            )
            ->whereDate('m.registration_date', $validated['report_date'])
            ->whereIn('mt.name', ['Movimiento Entrada', 'Movimiento Interno']);

        // Filtrar por tipo si se especificó
        if (!empty($validated['report_type'])) {
            $query->where('mt.name', $validated['report_type']);
        }

        $movements = $query->orderBy('m.registration_date', 'desc')->get();

        // Calcular totales usando colecciones de Laravel
        $totalEntradas = $movements->where('movement_type_name', 'Movimiento Entrada')->sum('amount');
        $totalInternos = $movements->where('movement_type_name', 'Movimiento Interno')->sum('amount');

        return response()->json([
            'movements' => $movements,
            'reportDate' => Carbon::parse($validated['report_date'])->format('d/m/Y'),
            'reportType' => $validated['report_type'] ?? null,
            'totalEntradas' => $totalEntradas,
            'totalInternos' => $totalInternos,
            'totalGeneral' => $totalEntradas + $totalInternos
        ]);
    }
    //descargar pdf
    public function downloadMovementReport(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'report_type' => 'nullable|in:Movimiento Entrada,Movimiento Interno'
        ]);

        $reportDate = $request->report_date;
        $reportType = $request->report_type;

        $query = DB::table('movement_details as md')
            ->join('movements as m', 'md.movement_id', '=', 'm.id')
            ->join('movement_responsibilities as mr', 'm.id', '=', 'mr.movement_id')
            ->join('movement_types as mt', 'm.movement_type_id', '=', 'mt.id')
            ->join('people as p', 'mr.person_id', '=', 'p.id')
            ->join('inventories as i', 'md.inventory_id', '=', 'i.id')
            ->join('elements as e', 'i.element_id', '=', 'e.id')
            ->select(
                'e.name as product_name',
                'm.registration_date',
                'm.return_date',
                'mt.name as movement_type_name',
                'm.observation',
                'm.state as movement_state',
                'p.first_name',
                'p.first_last_name',
                'p.second_last_name',
                'md.amount',
                'mr.person_id'
            )
            ->whereDate('m.registration_date', $reportDate)
            ->whereIn('mt.name', ['Movimiento Entrada', 'Movimiento Interno']);

        if ($reportType) {
            $query->where('mt.name', $reportType);
        }

        $movements = $query->orderBy('m.registration_date', 'desc')->get();

        $totalEntradas = $movements->where('movement_type_name', 'Movimiento Entrada')->sum('amount');
        $totalInternos = $movements->where('movement_type_name', 'Movimiento Interno')->sum('amount');

        $data = [
            'movements' => $movements,
            'reportDate' => Carbon::parse($reportDate)->format('d/m/Y'),
            'reportType' => $reportType,
            'totalEntradas' => $totalEntradas,
            'totalInternos' => $totalInternos,
            'totalGeneral' => $totalEntradas + $totalInternos
        ];

        $pdf = Pdf::loadView('solicitud::warehouseman.report-pdf', $data);
        $fileName = 'reporte_movimientos_' . $reportDate . ($reportType ? '_' . str_replace(' ', '_', $reportType) : '') . '.pdf';

        return $pdf->download($fileName);
    }

}

