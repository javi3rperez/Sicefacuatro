@extends('solicitud::layouts.master') 

@section('content')
<br>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class=""></i>Inventario Almacén
        </h2>
        <a href="" class="btn btn-success btn-lg shadow-sm">
            <i class="fas fa-plus mr-2"></i>Agregar Item
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

    <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-gradient-primary text-white">
                <tr>
                    <th class="py-3 align-middle border-0 font-weight-light">ID</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Lotes</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Categorías</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Productos</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Cantidad</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventory as $item)
                <tr class="border-bottom">
                    <td class="align-middle font-weight-bold text-dark">{{ $item['id'] }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-3">
                                        <i class="fas fa-tag text-success"></i>
                                    </div>
                                    <span>{{ $item['lote'] }}</span>
                                </div>
                            </td>
                             <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <span>{{ $item['categoria'] }}</span>
                                </div>
                            </td>
                             <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-info mr-3">
                                        <i class="fas fa-phone text-info"></i>
                                    </div>
                                    <span>{{ $item['producto'] }}</span>
                                </div>
                            </td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-light-warning mr-3">
                                <i class="fas fa-box text-warning"></i>
                            </div>
                            <span>{{ $item['cantidad'] }}</span>
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

@endsection