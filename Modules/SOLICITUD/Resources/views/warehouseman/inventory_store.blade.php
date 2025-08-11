@extends('solicitud::layouts.masterstore') 

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
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-success btn-lg shadow-sm" data-toggle="modal" data-target="#addItemModal">
                            <i class="fas fa-plus mr-2"></i>Agregar Producto
                        </a>
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
                        <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#editItemModal{{ $item['id'] }}">
                            <i class="fas fa-pencil-alt mr-1"></i> Editar
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#detailsModal{{ $item['id'] }}">
                            <i class="fas fa-eye mr-1"></i> Detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Edición -->
        <div class="modal fade" id="editItemModal{{ $item['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel{{ $item['id'] }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success text-white">
                        <h5 class="modal-title" id="editItemModalLabel{{ $item['id'] }}">Editar Producto</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $item['name'] }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="warehouse_name">Almacén</label>
                                        <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" value="{{ $item['warehouse_name'] }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">Categoría</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $item['category_name'] }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $item['stock'] }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">Imagen del Producto</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                            <label class="custom-file-label" for="image">Seleccionar archivo</label>
                                        </div>
                                        @if(!empty($item['image']))
                                            <small class="form-text text-muted">Imagen actual: {{ basename($item['image']) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>
                    </form>
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

<!-- Modal para Agregar Item -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="addItemModalLabel">Agregar Nuevo Producto</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <form action="{{ route('solicitud.store.inventory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h4>Nuevo Producto de Inventario</h4>
                    
                    <div class="row">
                        <!-- Primera columna -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Nombre</strong></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Almacén</strong></label>
                                <select class="form-control select2" name="warehouse_id" required>
                                    <option value="">Seleccione un almacén</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label><strong>Categoría</strong></label>
                                <select class="form-control select2" name="category_id" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label><strong>Stock</strong></label>
                                <input type="number" class="form-control" name="stock" min="0" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Descripción</strong></label>
                                <input type="text" class="form-control" name="description" required>
                            </div>
                        </div>

                        <!-- Segunda columna -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Precio</strong></label>
                                <input type="number" class="form-control" name="price" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Personas</strong></label>
                                <input type="text" class="form-control" name="person_id" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Almacén de unidad productiva</strong></label>
                                <input type="text" class="form-control" name="productive_unit_warehouse_id" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Fecha de producción</strong></label>
                                <input type="date" class="form-control" name="production_date" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Destino</strong></label>
                                <input type="text" class="form-control" name="destination" required>
                            </div>

                            <div class="form-group">
                                <label><strong>Imagen del Producto</strong></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" accept="image/*">
                                    <label class="custom-file-label">Seleccionar archivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-gradient-success {
        background: linear-gradient(135deg, #45c23c 0%, #40971d 100%) !important;
    }
    .catalog-img {
        height: 180px;
        width: 100%;
        object-fit: cover;
    }
    .catalog-img-placeholder {
        height: 180px;
        width: 100%;
        background-color: #f8f9fa;
    }
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .custom-file-label::after {
        content: "Buscar";
    }
    .pagination-green .page-link {
        color: #397a1f;
        border-color: #d1e7dd;
        transition: all 0.3s ease;
    }
    .pagination-green .page-link:hover {
        color: white;
        background-color: #2d6e14;
        border-color: #2d6e14;
    }
    .pagination-green .page-item.active .page-link {
        background-color: #307216;
        border-color: #327318;
    }
    .pagination-green {
        border-radius: 20px;
        overflow: hidden;
    }
</style>

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