@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container-fluid py-5">
    <!-- Título principal y botón -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-exchange-alt mr-2"></i> Entradas y Salidas de Inventario
        </h2>
        <button class="btn btn-success" data-toggle="modal" data-target="#newMovementModal">
            <i class="fas fa-plus mr-2"></i> Nuevo Registro
        </button>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-success">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle mr-3 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Tabla de movimientos -->
    <div class="card border-success shadow-lg rounded-lg">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0 font-weight-bold">
                <i class="fas fa-list-ol mr-2"></i> Registro de Entradas y Salidas
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="py-3 align-middle border-0">ID</th>
                            <th class="py-3 align-middle border-0">Tipo de Movimiento</th>
                            <th class="py-3 align-middle border-0">Cantidad</th>
                            <th class="py-3 align-middle border-0">Ubicación</th>
                            <th class="py-3 align-middle border-0">Categoría</th>
                            <th class="py-3 align-middle border-0">Producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de fila -->
                        <tr>
                            <td class="align-middle">1</td>
                            <td class="align-middle">
                                <span class="badge badge-success">Entrada</span>
                            </td>
                            <td class="align-middle">50</td>
                            <td class="align-middle">Almacén A</td>
                            <td class="align-middle">Oficina</td>
                            <td class="align-middle">Marcadores</td>
                        </tr>
                        <!-- Más filas aquí -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Paginación u otros elementos del footer -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Movimiento -->
<div class="modal fade" id="newMovementModal" tabindex="-1" role="dialog" aria-labelledby="newMovementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="newMovementModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i> Nuevo Registro
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newMovementForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Tipo de Movimiento</label>
                                <select class="form-control border-success" name="movement_type" required>
                                    <option value="">Seleccione...</option>
                                    <option value="entry">Entrada</option>
                                    <option value="exit">Salida</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Cantidad</label>
                                <input type="number" class="form-control border-success" name="quantity" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Ubicación</label>
                                <select class="form-control border-success" name="location_id" required>
                                    <option value="">Seleccione...</option>
                                    <!-- Opciones de ubicaciones -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Categoría</label>
                                <select class="form-control border-success" name="category_id" required>
                                    <option value="">Seleccione...</option>
                                    <!-- Opciones de categorías -->
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Producto</label>
                                <select class="form-control border-success" name="product_id" required>
                                    <option value="">Seleccione...</option>
                                    <!-- Opciones de productos -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Fecha</label>
                                <input type="date" class="form-control border-success" name="movement_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-success">Comentarios</label>
                        <textarea class="form-control border-success" name="comments" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveMovementBtn">
                    <i class="fas fa-save mr-2"></i> Guardar Registro
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success {
        background-color: #28a745 !important;
    }
    .btn-outline-success:hover {
        color: white !important;
    }
    .border-success {
        border-color: #28a745 !important;
    }
    .card {
        border-radius: 12px !important;
    }
    .badge-success {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
        padding: 5px 10px;
        font-weight: 600;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(40, 167, 69, 0.05);
    }
</style>

@section('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Lógica para guardar el movimiento
    $('#saveMovementBtn').click(function() {
        // Aquí iría la lógica para guardar el movimiento
        alert('Movimiento guardado exitosamente');
        $('#newMovementModal').modal('hide');
    });
});
</script>
@endsection

@endsection