<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Inventory;

class InstructorController extends Controller
{
    public function inventory_instructor()
    {
        $inventoryData = Inventory::with([
            'element.category',       // nombre y categoría del producto
            'productiveUnitWarehouse' // almacén del producto
        ])->get();

        $inventory = $inventoryData->map(function ($item) {
            return [
                'id'             => $item->id,
                'name'           => data_get($item, 'element.name', 'Producto desconocido'),
                'category_name'  => data_get($item, 'element.category.name', 'Sin categoría'),
                'warehouse_name' => data_get($item, 'productiveUnitWarehouse.warehouse.name', 'Sin almacén'),
                'stock'          => $item->stock ?? 0,
                'image'          => $item->image
            ];
        });

        return view('solicitud::instructor.inventory', compact('inventory'));
    }

    /**
     * Mostrar formulario para crear solicitud (sin guardar aún)
     */
    public function request_instructor()
    {
        $productos = [
            (object)['id' => 1, 'nombre' => 'Alcohol'],
            (object)['id' => 2, 'nombre' => 'Guantes']
        ];

        $lotes = [
            (object)['id' => 101],
            (object)['id' => 102]
        ];

        return view('solicitud::instructor.request', compact('productos', 'lotes'));
    }

    /**
     * Mostrar historial de solicitudes (simulado)
     */
    public function history_instructor()
    {
        $solicitudes = [
            (object)[
                'producto' => (object)['nombre' => 'Alcohol'],
                'cantidad' => 2,
                'estado' => 'enviada',
                'created_at' => now()
            ],
            (object)[
                'producto' => (object)['nombre' => 'Guantes'],
                'cantidad' => 5,
                'estado' => 'aceptada',
                'created_at' => now()->subDays(2)
            ]
        ];

        return view('solicitud::instructor.history', compact('solicitudes'));
    }
}
