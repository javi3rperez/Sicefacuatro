<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Modules\SOLICITUD\Entities\Person;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Request as Solicitud;

class ListController extends Controller
{
    // ----------------------------------------------------------------
    // LISTADOS
    // ----------------------------------------------------------------

    /**
     * Listado de solicitudes aprobadas para el almacenista, con filtros por fecha y nombre.
     */
    public function list_warehouseman(Request $request)
    {
        $query = Solicitud::query()
            ->select(['id','accountable_name','request_date','status'])
            ->where('status', 'Approved') // Solo solicitudes aprobadas
            ->orderBy('request_date', 'desc');

        // Filtro por fecha
        if ($request->filled('date')) {
            $query->whereDate('request_date', $request->date);
        }

        // Filtro por nombre
        if ($request->filled('name')) {
            $query->where('accountable_name', 'like', '%'.$request->name.'%');
        }

        // Paginación
        $list = $query->paginate(10);

        return view('solicitud::warehouseman.List_store', [
            'list' => $list,
            'date_selected' => $request->date,
            'name_selected' => $request->name
        ]);
    }

    /**
     * Muestra el detalle de una solicitud para el almacenista.
     */
    public function showWarehouseman($id)
    {
        $solicitud = Solicitud::with('items')->findOrFail($id);

        return view('solicitud::warehouseman.request_store', compact('solicitud'));
    }

    /**
     * Listado de solicitudes para el administrador de almacén, con filtros por fecha y nombre.
     */
    public function list_warehouseadmin(Request $request)
    {
        $query = Solicitud::query()
            ->select(['id','accountable_name','request_date','status'])
            ->orderBy('request_date', 'desc');

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('request_date', $request->fecha);
        }

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('accountable_name', 'like', '%'.$request->nombre.'%');
        }

        $list = $query->paginate(10);

        return view('solicitud::warehouseadmin.list_admin', [
            'list' => $list,
            'fecha_seleccionada' => $request->fecha,
            'nombre_seleccionado' => $request->nombre
        ]);
    }

    /**
     * Listado de solicitudes aprobadas para el almacenista, con filtro por fecha exacta.
     */
    public function list_store(Request $request)
    {
        $query = Solicitud::select(
            'id',
            'accountable_name',
            'request_date',
            'status',
            'approved_by_name'
        )
        ->with(['items' => function ($q) {
            $q->select('id', 'request_id', 'observation');
        }])
        ->where('status', 'approved');

        // Filtro por fecha exacta
        if ($request->filled('date')) {
            $query->whereDate('request_date', $request->date);
        }

        $solicitudes = $query->orderBy('request_date', 'desc')->paginate(10);

        return view('solicitud::warehouseman.list_store', [
            'solicitudes' => $solicitudes,
            'date_selected' => $request->date
        ]);
    }

    // ----------------------------------------------------------------
    // CRUD
    // ----------------------------------------------------------------

    /**
     * Muestra el formulario de creación de solicitud.
     */
    public function create()
    {
        return view('solicitud::create');
    }

    /**
     * Almacena una nueva solicitud (no implementado).
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra el detalle de una solicitud para el administrador de almacén.
     */
    public function show($id)
    {
        $solicitud = Solicitud::with(['person', 'movementType', 'items'])
                        ->findOrFail($id);

        return view('solicitud::warehouseadmin.request_admin', compact('solicitud'));
    }

    /**
     * Muestra el formulario de edición de solicitud.
     */
    public function edit($id)
    {
        return view('solicitud::edit');
    }

    // ----------------------------------------------------------------
    // UPDATE STATUS (aprobación/rechazo con firma)
    // ----------------------------------------------------------------

    /**
     * Actualiza el estado de una solicitud (aprobación o rechazo), guarda firma y observaciones.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'observation' => 'nullable|string|max:500',
            'observations' => 'array',
            'observations.*' => 'nullable|string|max:500',
            'signature_name' => 'nullable|string|max:255',
            'signature_role' => 'nullable|string|max:255',
        ]);

        $solicitud = Solicitud::with('items')->findOrFail($id);

        // Actualiza el estado de la solicitud
        $solicitud->status = $request->status;

        if ($request->status === 'rejected') {
            // Si es rechazado: no hay aprobador del sistema
            $solicitud->approved_by = null;
            $solicitud->approved_by_name = null;
        } else {
            // Si es aprobado: guardar usuario autenticado como aprobador
            $user = auth()->user();
            $solicitud->approved_by = $user->id ?? null;
            $solicitud->approved_by_name = $user->name ?? 'Administrador';
        }

        // En ambos casos se guardan los campos de firma (nombre y cargo)
        $solicitud->signature_name = $request->input('signature_name');
        $solicitud->signature_role = $request->input('signature_role');

        $solicitud->updated_by = auth()->id();
        $solicitud->save();

        // Guardar observaciones individuales por ítem
        if ($request->has('observations')) {
            foreach ($request->input('observations', []) as $itemId => $obs) {
                if ($item = $solicitud->items()->where('id', $itemId)->first()) {
                    $item->update(['observation' => $obs ?: null]);
                }
            }
        }

        // Aplicar observación global si viene
        if ($request->filled('observation')) {
            foreach ($solicitud->items as $item) {
                $item->update(['observation' => $request->observation]);
            }
        }

        return redirect()
            ->route('solicitud.admin.record')
            ->with('success', 'La solicitud fue ' . ($request->status == 'approved' ? 'aprobada' : 'rechazada') . ' correctamente.');
    }

    /**
     * Elimina una solicitud (no implementado).
     */
    public function destroy($id)
    {
        //
    }
}
