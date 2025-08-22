<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Inventory;
use Modules\SOLICITUD\Entities\Request as Solicitud; 
use Modules\SOLICITUD\Entities\Person;
use Modules\SOLICITUD\Entities\Movement;
use Modules\SOLICITUD\Entities\MovementType;

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


    public function request_instructor()
    {
        $persons = Person::all();
        $movement_types = MovementType::all();
        return view('solicitud::instructor.request', compact('persons', 'movement_types'));
        
    }

     /**
     * Muestra el historial de solicitudes del instructor
     */
    public function history_instructor()
    {
        $user = auth()->user();

        if (!$user->person) {
            return back()->withErrors('No hay una persona asociada a este usuario.');
        }

        // capturamos el filtro
        $estado = request('estado');

        // construimos la consulta base
        $query = Solicitud::select([
                'id',
                'observation',
                'request_date',
                'status',
            ])
            ->where('person_id', $user->person->id)
            ->orderByDesc('created_at');

        // aplicamos filtro si se seleccionó estado
        if (!empty($estado)) {
            $query->where('status', $estado);
        }

        // ejecutamos la consulta con paginación y mantenemos parámetros GET
        $solicitudes = $query->paginate(10)->withQueryString();

        return view('solicitud::instructor.history', compact('solicitudes'));
    }


    
    public function store_instructor(Request $request)
    {
        $user = auth()->user();

        // Crear la solicitud
        $solicitud = new Solicitud();
        $solicitud->request_date = $request->request_date;
        $solicitud->mba_area = $request->mba_area;
        $solicitud->regional_code = $request->regional_code;
        $solicitud->regional_name = $request->regional_name;
        $solicitud->cost_center_code = $request->cost_center_code;
        $solicitud->cost_center_name = $request->cost_center_name;
        $solicitud->office_manager_name = $request->office_manager_name;
        $solicitud->accountable_type = $request->accountable_type;
        $solicitud->accountable_number = $request->accountable_number;
        $solicitud->destinations_requested_goods = $request->destinations_requested_goods;
        $solicitud->group_or_record_code = $request->group_or_record_code;
        $solicitud->person_id = $user->person->id;
        $solicitud->movement_type_id = $request->movement_type_id;

        // Primer bien de la solicitud
        $solicitud->sena_code = $request->sena_code[0] ?? null;
        $solicitud->item_description = $request->item_description[0] ?? null;
        $solicitud->measurement_unit = $request->measurement_unit[0] ?? null;
        $solicitud->requested_quantity = $request->requested_quantity[0] ?? null;
        $solicitud->delivered_quantity = $request->delivered_quantity[0] ?? null;
        $solicitud->observation = $request->observation[0] ?? null;

        // Estado inicial de la solicitud
        $solicitud->status = 'pending';
        $solicitud->save();

        // Crear movimiento asociado
        $stateMap = [
            'pending'   => 'Solicitado',
            'approved'  => 'Aprobado',
            'rejected'  => 'Rechazado',
            'completed' => 'Devuelto',
        ];

        $movement = new Movement();
        $movement->request_id = $solicitud->id;
        $movement->movement_type_id = $solicitud->movement_type_id;
        $movement->observation = $solicitud->observation;
        $movement->state = $stateMap[$solicitud->status] ?? 'Solicitado';
        $movement->registration_date = now();
        $movement->voucher_number = 0; // si es obligatorio
        $movement->price = 0;          // si es obligatorio
        $movement->save();

        return redirect()->route('solicitud.instructor.history')->with('success', 'Solicitud enviada correctamente');
    }




    public function destroy_instructor($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->delete();

        return redirect()->route('solicitud.instructor.history')->with('success', 'Solicitud eliminada correctamente');
    }
    
    public function movements_instructor()
    {
        $user = auth()->user();

        if (!$user->person) {
            return back()->withErrors('No hay una persona asociada a este usuario.');
        }

        $movimientos = Movement::with(['movementType', 'request'])
            ->whereHas('request', function ($q) use ($user) {
                $q->where('person_id', $user->person->id);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('solicitud::instructor.movements', compact('movimientos'));
    }
}

