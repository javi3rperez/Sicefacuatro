@extends('solicitud::layouts.masterstore') 

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Inventario Almacén</h2>
        <a href="" class="btn btn-success">
            <i class="fas fa-plus"></i> Agregar Item
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Lotes</th>
                    <th>Categorías</th>
                    <th>Productos</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
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
                    <td>
                        <a href="" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection