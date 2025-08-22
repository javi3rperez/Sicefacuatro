<?php

namespace Modules\SOLICITUD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SOLICITUD\Entities\Evidence;
use Illuminate\Support\Facades\DB;
use Modules\SOLICITUD\Entities\Category;

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
    $evidence = DB::table('evidences')
        ->join('categories', 'evidences.category_id', '=', 'categories.id')
        ->select('evidences.*', 'categories.name as category_name')
        ->when($request->input('category_id'), function ($query) use ($request) {
            return $query->where('evidences.category_id', $request->input('category_id'));
        })
        ->orderBy('evidences.created_at', 'desc')
        ->paginate(10);

    $categories = Category::all(); // Obtener todas las categorías para el filtro/modal

    return view('solicitud::warehouseman.evidence_store', compact('evidence', 'categories'));
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
