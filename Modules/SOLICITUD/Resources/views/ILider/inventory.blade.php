
@extends('layouts.masterleader') 

@section('content')
<div class="container mt-5">
    <h2 class="text-success mb-4">Inventario Bodega</h2>
    <table class="table table-bordered">
        <thead class="table-light">
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
