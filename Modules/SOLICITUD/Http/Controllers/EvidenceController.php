<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Evidence;

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
        $query = Evidence::query()
            ->select([
                'id',
                'lot_number',
                'product_name',
                'movement_type',
                'evidence_path',
                'user_name',
                'created_at'
            ])
            ->orderBy('created_at', 'desc');

        // Aplicar filtros
        if ($request->filled('lot')) {
            $query->where('lot_number', 'like', '%'.$request->lot.'%');
        }

        if ($request->filled('product')) {
            $query->where('product_name', 'like', '%'.$request->product.'%');
        }

        if ($request->filled('movement_type')) {
            $query->where('movement_type', $request->movement_type);
        }

        $evidence = $query->paginate(15);

        return view('solicitud::warehouseman.evidence_store', compact('evidence'));
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
