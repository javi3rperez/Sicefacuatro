@extends('solicitud::layouts.masterstore')

@section('content')
<br>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class=""></i>Gestión de Lotes
        </h2>
        <a href="" class="btn btn-success btn-lg shadow-sm">
            <i class="fas fa-plus mr-2"></i>Agregar Lote
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
                <i class="fas fa-list-alt mr-2 text-success"></i>Listado de Lotes
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th class="py-3 align-middle border-0 font-weight-light">ID</th>
                            <th class="py-3 align-middle border-0 font-weight-light">Nombre</th>
                            <th class="py-3 align-middle border-0 font-weight-light">Ubicación</th>
                            <th class="py-3 align-middle border-0 font-weight-light">Teléfono</th>
                            <th class="py-3 align-middle border-0 font-weight-light text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lots as $lote)
                        <tr class="border-bottom">
                            <td class="align-middle font-weight-bold text-dark">{{ $lote['id'] }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-3">
                                        <i class="fas fa-tag text-success"></i>
                                    </div>
                                    <span>{{ $lote['nombre'] }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <span>{{ $lote['ubicacion'] }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-info mr-3">
                                        <i class="fas fa-phone text-info"></i>
                                    </div>
                                    <span>{{ $lote['telefono'] }}</span>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="" class="btn btn-sm btn-icon btn-soft-primary rounded-circle mr-2 shadow-sm" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-soft-danger rounded-circle shadow-sm" onclick="return confirm('¿Está seguro de eliminar este lote?')" title="Eliminar">
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
        <div class="card-footer bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Mostrando {{ count($lots) }} registros
                </div>
               
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
    }
    .text-gradient-success {
        background: -webkit-linear-gradient(45deg, #2b5876, #4e4376);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
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
    .rounded-lg {
        border-radius: 12px !important;
    }
</style>
@endsection