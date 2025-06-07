@extends('solicitud::layouts.masterstore')

@section('content')
<br>
<div class="container mt-4">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            Registro de Evidencias
        </h2>
        <a href="" class="btn btn-success btn-lg shadow-sm">
            <i class="fas fa-plus mr-2"></i>Agregar Categoría
        </a>
    </div>

 @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle mr-3 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 text-secondary font-weight-bold">
                <i class="fas fa-list-alt mr-2 text-success"></i>Listado de Productos
            </h5>
        </div>
        <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th class="py-3 align-middle border-0 font-weight-light">ID</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Lote</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Producto</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Tipo Movimiento</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Usuario</th>
                    <th class="py-3 align-middle border-0 font-weight-light text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidence as $evidencia)
                <tr>
                     <td class="align-middle font-weight-bold text-dark">{{ $evidencia['id'] }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-warning mr-3">
                                        <i class="fas fa-box text-warning"></i>
                                    </div>
                                    
                                </div>
                            </td>
                            

                    <td>{{ $evidencia['id'] }}</td>
                    
                    
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
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
    }
    .icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-soft-primary {
        background-color: rgba(77, 171, 247, 0.1);
        color: #4dabf7;
        transition: all 0.3s;
    }
    .btn-soft-primary:hover {
        background-color: #4dabf7;
        color: white;
    }
    .btn-soft-danger {
        background-color: rgba(237, 76, 120, 0.1);
        color: #ed4c78;
        transition: all 0.3s;
    }
    .btn-soft-danger:hover {
        background-color: #ed4c78;
        color: white;
    }
    .bg-light-success {
        background-color: rgba(40, 167, 69, 0.1);
    }
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .bg-light-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
    .rounded-lg {
        border-radius: 12px !important;
    }
</style>
@endsection
@endsection