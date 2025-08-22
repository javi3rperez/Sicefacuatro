@extends('solicitud::layouts.masterinstructor')

@section('content')

<title>Movimientos de Inventario</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }
    header {
        padding: 15px;
        background-color: white;
        border-bottom: 1px solid #ddd;
    }
    .container {
        padding: 20px;
    }
    h2 {
        color: #28a745;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #28a745;
    }
    .card-header {
        background-color: #28a745;
        padding: 10px;
        color: white;
        font-weight: bold;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .badge {
        background-color: #d4edda;
        color: #155724;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 0.9em;
    }
    .empty-message {
        text-align: center;
        color: #6c757d;
        padding: 15px;
    }
</style>

<div class="container">
    <h2><i class="fas fa-random"></i> Movimientos de Inventario</h2>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-list"></i> Registro de Movimientos
        </div>
        <table>
            <thead>
                <tr> 
                    <th>ID</th>
                    <th>Tipo de Movimiento</th>
                    <th>Almacén</th>
                    <th>Elemento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $movimiento) 
                    <tr>
                        <td>{{ $movimiento->id }}</td>
                        <td>
                            <span class="badge">
                                {{ $movimiento->movementType->name ?? 'Sin tipo' }}
                            </span>
                        </td>
                        <td>{{ $movimiento->request->cost_center_name ?? 'Sin almacén' }}</td>
                        <td>{{ $movimiento->request->item_description ?? 'Sin elemento' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-message">
                            <i class="fas fa-info-circle"></i> No hay movimientos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
