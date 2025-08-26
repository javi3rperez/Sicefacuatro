esta es la vista: 
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
                    <div class="col-md-4 text-right">
                        <div class="d-flex justify-content-end align-items-end h-100">
                        </div>
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
            <form action="{{ route('solicitud.store.inventory.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Primera columna -->
                        <div class="col-md-6">
                            <!-- Unidad productiva -->
                            <div class="form-group">
                                <label><strong>Almacen de unidad productiva</strong></label>
                                <select class="form-control select2" name="productive_unit_warehouse_id" required>
                                    <option value="">Seleccione una unidad productiva</option>
                                    @foreach($productiveWarehouses as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->productive_unit_name }} - {{ $item->warehouse_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Elemento -->
                            <div class="form-group">
                                <label><strong>Elemento</strong></label>
                                <input type="text" name="element_name" id="element_name" class="form-control" placeholder="Escribe el nombre del producto">
                            </div>

                            <!-- Destino -->
                            <div class="form-group">
                                <label><strong>Destino</strong></label>
                                <select class="form-control select2" name="destination" required>
                                    <option value="">Seleccione un destino</option>
                                   <option value="Producción">Producción</option>
                                   <option value="Formación">Formación</option>
                                </select>
                            </div>

                            <!-- Estado -->
                            <div class="form-group">
                                <label><strong>Estado</strong></label>
                                <select class="form-control select2" name="state" required>
                                    <option value="">Seleccione estado</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="No disponible">No disponible</option>
                                </select>
                            </div>
                            <!-- Fecha de Expiración -->
                            <div class="form-group">
                                <label><strong>Fecha de Expiración</strong></label>
                                <input type="date" class="form-control" name="expiration_date">
                            </div>

                            <!-- Marca -->
                            <div class="form-group">
                                <label><strong>Marca</strong></label>
                                <input type="text" class="form-control" name="mark">
                            </div>

                            <!-- Código de Inventario -->
                            <div class="form-group">
                                <label><strong>Código de Inventario</strong></label>
                                <input type="text" class="form-control" name="inventory_code">
                            </div>
                            <!-- Dentro del formulario del modal -->
                            <div class="form-group">
                                <label><strong>Categoría</strong></label>
                                <select class="form-control select2" name="category_id" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Segunda columna -->
                        <div class="col-md-6">
                            <!-- Descripción -->
                            <div class="form-group">
                                <label><strong>Descripción</strong></label>
                                <input type="text" class="form-control" name="description" required>
                            </div>

                            <!-- Precio -->
                            <div class="form-group">
                                <label><strong>Precio</strong></label>
                                <input type="number" class="form-control" name="price" required>
                            </div>

                            <!-- Cantidad -->
                            <div class="form-group">
                                <label><strong>Cantidad</strong></label>
                                <input type="number" class="form-control" name="amount" min="1" required>
                            </div>

                            <!-- Stock -->
                            <div class="form-group">
                                <label><strong>Stock</strong></label>
                                <input type="number" class="form-control" name="stock" min="0" required>
                            </div>

                            <!-- Fecha de Producción -->
                            <div class="form-group">
                                <label><strong>Fecha de Producción</strong></label>
                                <input type="date" class="form-control" name="production_date">
                            </div>

                            <!-- Lote -->
                            <div class="form-group">
                                <label><strong>Número de Lote</strong></label>
                                <input type="text" class="form-control" name="lot_number">
                            </div>

                            <!-- Imagen -->
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
   // Filtros interactivos mejorados
document.getElementById('filterSearch').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    
    document.querySelectorAll('.col-xl-3.col-lg-4.col-md-6.mb-4').forEach(function(column) {
        const cardText = column.textContent.toLowerCase(); // incluye todo el contenido de la tarjeta
        if (cardText.includes(searchValue)) {
            column.style.display = '';
        } else {
            column.style.display = 'none';
        }
    });
});

</script>
@endsection