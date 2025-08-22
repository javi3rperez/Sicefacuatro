@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container-fluid py-5">
    <!-- Contenedor para notificaciones toast -->
    <div id="notification-toast" class="toast" style="position: fixed; top: 20px; right: 20px; min-width: 350px; z-index: 9999; display: none;">
        <div class="toast-header bg-success text-white">
            <strong class="mr-auto"><i class="fas fa-check-circle"></i> ¡Éxito!</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-light">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x text-success mr-3"></i>
                <div>
                    <h6 class="mb-1">Movimiento registrado</h6>
                    <p class="mb-0" id="toast-message">El movimiento se ha guardado exitosamente</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Título principal -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-exchange-alt mr-2"></i> Entradas y Salidas de Inventario
        </h2>
        <button class="btn btn-success" data-toggle="modal" data-target="#filterModal">
            <i class="fas fa-filter mr-2"></i> Filtrar
        </button>
        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#reportModal">
            <i class="fas fa-file-pdf mr-2"></i> Reporte PDF
        </button>
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
                            <th class="py-3 align-middle">Producto</th>
                            <th class="py-3 align-middle">Cantidad</th>
                            <th class="py-3 align-middle">Tipo de Movimiento</th>
                            <th class="py-3 align-middle">Fecha Registro</th>
                            <th class="py-3 align-middle">Estado</th>
                            <th class="py-3 align-middle">Responsable</th>
                            <th class="py-3 align-middle">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                                @forelse($movements as $movement)
                                <tr>
                                    <td class="align-middle">{{ $movement->name }}</td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-info">
                                            {{ $movement->amount }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        @if($movement->movement_type_name == 'Movimiento Entrada')
                                            <span class="badge badge-success">
                                                <i class="fas fa-arrow-down mr-1"></i> Entrada
                                            </span>
                                        @elseif($movement->movement_type_name == 'Movimiento Interno')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exchange-alt mr-1"></i> Interno
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                {{ $movement->movement_type_name }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($movement->registration_date)->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle">
                                        <span class="badge {{ $movement->movement_state == 'Completado' ? 'badge-success' : 'badge-success' }}">
                                            {{ $movement->movement_state }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ $movement->first_name }} {{ $movement->first_last_name }} {{ $movement->second_last_name }}</td>
                                    <td class="align-middle">{{ $movement->observation ?? 'Sin observaciones' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No hay movimientos registrados</h5>
                                        <p class="text-muted">No se encontraron movimientos de entrada o interno</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                </table>
            </div>
        </div>
        <!-- Pie de página mejorado -->
        <div class="card-footer bg-white py-3">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <div class="text-success small">
                        Mostrando <span class="font-success-bold">{{ $movements->firstItem() }}</span> a 
                        <span class="font-weight-bold">{{ $movements->lastItem() }}</span> de 
                        <span class="font-weight-bold">{{ $movements->total() }}</span> registros
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $movements->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Filtros -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="fas fa-filter mr-2"></i> Filtrar Movimientos
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text-success">Tipo de Movimiento</label>
                        <select class="form-control border-success" name="type">
                            <option value="">Todos</option>
                            <option value="Movimiento Entrada" {{ request()->get('type') == 'Movimiento Entrada' ? 'selected' : '' }}>Movimiento Entrada</option>
                            <option value="Movimiento Interno" {{ request()->get('type') == 'Movimiento Interno' ? 'selected' : '' }}>Movimiento Interno</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Fecha desde</label>
                                <input type="date" class="form-control border-success" name="start_date" value="{{ request()->get('start_date') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter mr-2"></i> Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal para Nuevo Registro -->
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
            <form action="{{ route('solicitud.store.movement.create') }}" method="POST" id="movementForm">
                @csrf
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success font-weight-bold required-field">Tipo de Movimiento</label>
                                <select class="form-control border-success" name="movement_type" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Movimiento Entrada">Movimiento Entrada</option>
                                    <option value="Movimiento Interno">Movimiento Interno</option>
                                </select>
                                <div class="error-message text-danger" id="movement_type_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success font-weight-bold required-field">Producto</label>
                                <select class="form-control border-success" name="element_id" required>
                                    <option value="">Seleccione un producto...</option>
                                    @foreach($elements as $element)
                                        <option value="{{ $element->id }}" {{ old('element_id') == $element->id ? 'selected' : '' }}>
                                            {{ $element->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="error-message text-danger" id="element_id_error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-success font-weight-bold required-field">Cantidad</label>
                                <input type="number" class="form-control border-success" name="amount" min="1" required value="{{ old('amount') }}">
                                <div class="error-message text-danger" id="amount_error">
                                    @error('amount')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-success font-weight-bold required-field">Fecha Registro</label>
                                <input type="datetime-local" class="form-control border-success" name="registration_date" required value="{{ old('registration_date', now()->format('Y-m-d\TH:i')) }}">
                                <div class="error-message text-danger" id="registration_date_error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-success font-weight-bold required-field">Responsable</label>
                                <select class="form-control border-success" name="responsible" required>
                                    <option value="">Seleccione un responsable...</option>
                                    @foreach($responsibles as $responsible)
                                        <option value="{{ $responsible->id }}">
                                            {{ $responsible->first_name }} {{ $responsible->first_last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="error-message text-danger" id="responsible_error"></div>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="text-success font-weight-bold">Observaciones</label>
                        <textarea class="form-control border-success" name="observation" rows="3" placeholder="Ingrese observaciones relevantes...">{{ old('observation') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para Reporte PDF (Configuración) -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="reportModalLabel">
                    <i class="fas fa-file-pdf mr-2"></i> Generar Reporte PDF
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reportForm" action="{{ route('solicitud.report.movements.download') }}" method="POST" target="_blank">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label class="text-success font-weight-bold">Seleccione la fecha del reporte</label>
            <input type="date" class="form-control border-success" name="report_date" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label class="text-success font-weight-bold">Tipo de Movimiento</label>
            <select class="form-control border-success" name="report_type">
                <option value="">Todos los movimientos</option>
                <option value="Movimiento Entrada">Movimientos Entradas</option>
                <option value="Movimiento Interno">Movimientos Internos</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" data-dismiss="modal">
            <i class="fas fa-times mr-2"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-file-download mr-2"></i> Descargar PDF
        </button>
    </div>
</form>

        </div>
    </div>
</div>
<style>
/* Para hacer la paginación verde */
.pagination .page-item.active .page-link {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.pagination .page-link {
    color: #28a745;
    border-color: #28a745;
}

.pagination .page-link:hover {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}
</style>


<script>
document.getElementById('generateReportBtn').addEventListener('click', function() {
    // Obtener los valores del formulario
    const formData = new FormData(document.getElementById('reportForm'));
    
    // Mostrar spinner si existe
    const spinner = document.getElementById('reportSpinner');
    const button = this;
    if (spinner) {
        spinner.classList.remove('d-none');
        button.disabled = true;
    }
    
    // Realizar la petición POST
    fetch('{{ route("solicitud.report.movements") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            // Si la respuesta no es exitosa, lanzar error
            if (response.status === 405) {
                throw new Error('Método no permitido. Verifica que la ruta acepte POST.');
            }
            throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos del reporte:', data);
        alert('Reporte generado correctamente. Revisa la consola para ver los datos.');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al generar el reporte: ' + error.message);
    })
    .finally(() => {
        // Ocultar spinner y habilitar botón si existe
        if (spinner) {
            spinner.classList.add('d-none');
            button.disabled = false;
        }
    });
});
</script>

@endsection
