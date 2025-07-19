<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ListadminController extends Controller
{
    /**
     * Muestra el listado de solicitudes con filtros
     */
    public function list_warehouseadmin(Request $request)
    {
        try {
            // Query base con campos esenciales y ordenamiento primario por ID descendente
            $query = Product::query()
                ->select('id', 'name', 'program', 'date')
                ->orderBy('id', 'desc')  // Orden principal por ID descendente
                ->orderBy('date', 'desc'); // Orden secundario por fecha

            // Filtros dinámicos (se mantienen igual)
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            
            if ($request->filled('date')) {
                $query->whereDate('date', $request->date);
            }
            
            if ($request->filled('program')) {
                $query->where('program', $request->program);
            }

            // Paginación
            $list = $query->paginate(15)->withQueryString();

            // Transformación de datos
            $list->getCollection()->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name ?? 'N/A',
                    'program' => $item->program ?? 'Sin programa',
                    'date' => $item->date ? $item->date->format('d/m/Y H:i') : 'Fecha no especificada'
                ];
            });

            return view('solicitud::warehouseadmin.list_admin', compact('list'));

        } catch (\Exception $e) {
            \Log::error('Error en ListadminController: ' . $e->getMessage());
            $list = new LengthAwarePaginator([], 0, 15);
            return view('solicitud::warehouseadmin.list_admin', compact('list'))
                ->with('error', 'Error al cargar los datos');
        }
    }
public function formato_warehouseadmin($id)
{
    // Verificar permiso
    $this->authorize('solicitud.admin.formato');
    
    $solicitud = Product::findOrFail($id);
    $fechaFormateada = $solicitud->date ? $solicitud->date->format('d/m/Y') : date('d/m/Y');

    return view('solicitud::warehouseadmin.formato_solicitud', [
        'solicitud' => $solicitud,
        'fecha' => $fechaFormateada
    ]);
}
}