@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Registro de Evidencias</h2>
        <a href="" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Nueva Evidencia
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Lote</th>
                    <th>Producto</th>
                    <th>Tipo Movimiento</th>
                    <th>Usuario</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidence as $evidencia)
                <tr>
                    <td>{{ $evidencia['id'] }}</td>
                    <td>11</td>
                    <td>mm</td>
                    <td>holll</td>
                    <td>{{ $evidencia->usuario->name ?? 'Sistema' }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="" class="btn btn-sm btn-warning" title="Editar" data-toggle="tooltip">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Confirmar eliminación de esta evidencia?')" title="Eliminar" data-toggle="tooltip">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('scripts')
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
@endsection