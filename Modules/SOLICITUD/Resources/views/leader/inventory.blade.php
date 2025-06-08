@extends('solicitud::layouts.masterleader') 

@section('content')
<style>
    .inventario-container {
        padding: 2rem;
        background-color: #fff;
    }

    .inventario-title {
        color: #28a745; /* Verde SENA */
        font-weight: bold;
        text-align: center;
        margin-bottom: 2rem;
    }

    .inventario-table {
        width: 100%;
        border-collapse: collapse;
    }

    .inventario-table th,
    .inventario-table td {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        text-align: center;
        vertical-align: middle;
    }

    .inventario-table th {
        background-color: #f8f9fa;
        position: relative;
    }

    .dropdown-icon {
        margin-left: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    /* Opcional: efecto hover para filas */
    .inventario-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="inventario-container">
    <h2 class="inventario-title">Inventario Bodega</h2>

    <table class="inventario-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lotes</th>
                <th>Categorías</th>
                <th>Productos</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventory as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                 <td>{{ $item['lote'] }}</td>
                <td>{{ $item['categoria'] }}</td>
                <td>{{ $item['producto'] }}</td>
                <td>{{ $item['cantidad'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
