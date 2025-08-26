<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Inventory;
use Modules\SOLICITUD\Entities\Request as Solicitud; 
use Modules\SOLICITUD\Entities\Person;
use Modules\SOLICITUD\Entities\Movement;
use Modules\SOLICITUD\Entities\MovementType;
use Modules\SOLICITUD\Entities\RequestItem;

class RequestController extends Controller
{
    /**
     * Muestra el inventario para el líder.
     */
    public function inventory_leader()
    {
        // Obtiene el inventario con relaciones necesarias
        $inventoryData = Inventory::with([
            'element.category',
            'productiveUnitWarehouse'
        ])->get();

        // Mapea los datos para la vista
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

        // Retorna la vista con el inventario
        return view('solicitud::leader.inventory', compact('inventory'));
    }

    /**
     * Muestra el formulario para crear una nueva solicitud como líder.
     */
    public function request_leader()
    {
        $persons = Person::all();
        $movement_types = MovementType::all();
        return view('solicitud::leader.request', compact('persons', 'movement_types'));
    }

    /**
     * Muestra el historial de solicitudes del líder autenticado.
     */
    public function history_leader()
    {
        $user = auth()->user();

        // Verifica si el usuario tiene persona asociada
        if (!$user->person) {
            return back()->withErrors('No hay una persona asociada a este usuario.');
        }

        $estado = request('estado');

        // Consulta las solicitudes del usuario
        $query = Solicitud::with('items') //Cargar bienes asociados
            ->select([
                'id',
                'request_date',
                'status',
            ])
            ->where('person_id', $user->person->id)
            ->orderByDesc('created_at');

        // Filtra por estado si se proporciona
        if (!empty($estado)) {
            $query->where('status', $estado);
        }

        $solicitudes = $query->paginate(10)->withQueryString();

        // Retorna la vista con las solicitudes
        return view('solicitud::leader.history', compact('solicitudes')); // Cambiar vista a leader
    }

    /**
     * Almacena una nueva solicitud realizada por el líder.
     */
    public function store_leader(Request $request) // Cambiar nombre del método
    {
        $user = auth()->user();

        // Crear la solicitud (datos generales)
        $solicitud = new Solicitud();
        $solicitud->request_date                 = $request->request_date;
        $solicitud->mba_area                     = $request->mba_area;
        $solicitud->regional_code                = $request->regional_code;
        $solicitud->regional_name                = $request->regional_name;
        $solicitud->cost_center_code             = $request->cost_center_code;
        $solicitud->cost_center_name             = $request->cost_center_name;
        $solicitud->office_manager_name          = $request->office_manager_name;
        $solicitud->accountable_type             = $request->accountable_type;
        $solicitud->accountable_number           = $request->accountable_number;
        $solicitud->accountable_name             = $request->accountable_name ?? 'Sin nombre';
        $solicitud->destinations_requested_goods = $request->destinations_requested_goods;
        $solicitud->group_or_record_code         = $request->group_or_record_code;
        $solicitud->person_id                    = $user->person->id;
        $solicitud->movement_type_id             = $request->movement_type_id;
        $solicitud->status                       = 'pending'; // Estado inicial
        $solicitud->save();

        // Guardar los bienes en la tabla request_items
        if ($request->has('sena_code')) {
            foreach ($request->sena_code as $index => $sena_code) {
                RequestItem::create([
                    'request_id'         => $solicitud->id,
                    'sena_code'          => $sena_code,
                    'item_description'   => $request->item_description[$index] ?? null,
                    'measurement_unit'   => $request->measurement_unit[$index] ?? null,
                    'requested_quantity' => $request->requested_quantity[$index] ?? null,
                    'delivered_quantity' => $request->delivered_quantity[$index] ?? 0,
                    'observation'        => $request->observation[$index] ?? null,
                ]);
            }
        }

        // Crear movimiento asociado
        $stateMap = [
            'pending'   => 'Solicitado',
            'approved'  => 'Aprobado',
            'rejected'  => 'Rechazado',
            'completed' => 'Devuelto',
        ];

        $movement = new Movement();
        $movement->request_id        = $solicitud->id;
        $movement->movement_type_id  = $solicitud->movement_type_id;
        $movement->observation       = $solicitud->destinations_requested_goods; 
        $movement->state             = $stateMap[$solicitud->status] ?? 'Solicitado';
        $movement->registration_date = now();
        $movement->voucher_number    = 0; // si es obligatorio
        $movement->price             = 0; // si es obligatorio
        $movement->save();

        // Redirige al historial con mensaje de éxito
        return redirect()
            ->route('solicitud.leader.history') // Cambiar ruta a leader
            ->with('success', 'Solicitud enviada correctamente');
    }

    /**
     * Elimina una solicitud específica realizada por el líder.
     */
    public function destroy_leader($id) // Cambiar nombre del método
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->delete();

        return redirect()->route('solicitud.leader.history') // Cambiar ruta a leader
            ->with('success', 'Solicitud eliminada correctamente');
    }
    
    /**
     * Muestra los movimientos asociados a las solicitudes del líder autenticado.
     */
    public function movements_leader() // Cambiar nombre del método
    {
        $user = auth()->user();

        // Verifica si el usuario tiene persona asociada
        if (!$user->person) {
            return back()->withErrors('No hay una persona asociada a este usuario.');
        }

        // Obtiene los movimientos relacionados con las solicitudes del usuario
        $movimientos = Movement::with(['movementType', 'request.items'])
            ->whereHas('request', function ($q) use ($user) {
                $q->where('person_id', $user->person->id);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        // Retorna la vista con los movimientos
        return view('solicitud::leader.movements', compact('movimientos')); // Cambiar vista a leader
    }
}
