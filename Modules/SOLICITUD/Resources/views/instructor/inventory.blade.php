@extends('solicitud::layouts.masterinstructor')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-boxes"></i> Catálogo de Inventario
        </h2>
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
     <!-- Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body py-2">
            <form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="filterSearch" class="small font-weight-bold">Ingresar</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="filterSearch" placeholder="Producto, lote...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-success w-100">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <!-- Vista de Catálogo -->
    <div class="row">
        @foreach($inventory as $item)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="position-relative">
                    @if(!empty($item['image']))
                        <img src="{{ asset('storage/'.$item['image']) }}" class="card-img-top catalog-img" alt="{{ $item['name'] }}">
                    @else
                        <div class="catalog-img-placeholder d-flex align-items-center justify-content-center">
                            <i class="fas fa-box-open fa-3x text-secondary"></i>
                        </div>
                    @endif
                    <span class="badge badge-success position-absolute" style="top: 10px; right: 10px;">
                        {{ $item['stock'] }} en stock
                    </span>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title font-weight-bold mb-0">{{ $item['name'] }}</h5>
                        
                        <span class="badge badge-success">{{ $item['warehouse_name'] }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small d-block">
                            <i class="fas fa-tag text-success mr-1"></i> {{ $item['category_name'] }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#detailsModal{{ $item['id'] }}">
                            <i class="fas fa-eye mr-1"></i> Detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de Detalles -->
        <div class="modal fade" id="detailsModal{{ $item['id'] }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $item['id'] }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success text-white">
                        <h5 class="modal-title" id="detailsModalLabel{{ $item['id'] }}">Detalles del Producto</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            @if(!empty($item['image']))
                                <img src="{{ asset('storage/'.$item['image']) }}" class="img-fluid rounded" style="max-height: 200px;" alt="{{ $item['name'] }}">
                            @else
                                <div class="bg-light p-5 rounded">
                                    <i class="fas fa-box-open fa-4x text-secondary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">Producto:</span>
                                        <span>{{ $item['name'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">Categoría:</span>
                                        <span>{{ $item['category_name'] }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">Almacén:</span>
                                        <span>{{ $item['warehouse_name'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">Stock:</span>
                                        <span class="badge badge-pill badge-success">{{ $item['stock'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
     <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-green">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
 <script>
    // Script para mostrar el nombre del archivo seleccionado
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : "Seleccionar archivo";
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });

    // Filtros interactivos (ejemplo básico)
    document.getElementById('filterSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        document.querySelectorAll('.card-title').forEach(function(title) {
            const card = title.closest('.card');
            if (title.textContent.toLowerCase().includes(searchValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection