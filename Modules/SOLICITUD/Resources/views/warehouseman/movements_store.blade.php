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
                    <button type="submit', class="btn btn-success">
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
                                    <option value="6">Movimiento Entrada</option>
                                    <option value="2">Movimiento Interno</option>
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
                                <input type="text" class="form-control border-success bg-light" 
                                    value="{{ now()->format('d/m/Y H:i') }}" readonly>
                                <small class="form-text text-muted">Fecha actual (no editable)</small>
                                <!-- Campo oculto para enviar el valor en el formato correcto al servidor -->
                                <input type="hidden" name="registration_date" 
                                    value="{{ now()->format('Y-m-d\TH:i') }}">
                                <div class="error-message text-danger" id="registration_date_error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="position: relative;">
                                <label class="text-success font-weight-bold required-field">Responsable</label>
                                
                                <!-- Campo de búsqueda -->
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control border-success" id="responsibleSearch" 
                                           placeholder="Escribe para buscar responsable..." autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" id="searchButton">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Select oculto para el formulario -->
                                <select class="form-control border-success" name="responsible" id="responsibleSelect" required style="display: none;">
                                    <option value="">Seleccione un responsable...</option>
                                    @foreach($responsibles as $responsible)
                                        <option value="{{ $responsible->id }}">
                                            {{ $responsible->first_name }} {{ $responsible->first_last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <!-- Contenedor para resultados -->
                                <div id="responsibleResults" class="border border-success rounded bg-white" 
                                     style="max-height: 200px; overflow-y: auto; display: none; position: absolute; width: 100%; z-index: 1000;">
                                </div>
                                
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

#responsibleResults div {
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s;
}

#responsibleResults div:hover {
    background-color: #f8f9fa;
}

#responsibleResults div:last-child {
    border-bottom: none;
}
</style>

<script>

    // Silenciar errores de recursos externos y scripts de terceros
const originalError = console.error;
console.error = function(...args) {
    if (typeof args[0] === 'string' && (
        args[0].includes('integrity') || 
        args[0].includes('404') ||
        args[0].includes('getContext') ||
        args[0].includes('Raphael')
    )) {
        return; // Ignorar estos errores específicos
    }
    originalError.apply(console, args);
};

// Función para el reporte PDF
document.getElementById('generateReportBtn')?.addEventListener('click', function() {
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

// ===== FILTRO DE RESPONSABLES =====
(function() {
    'use strict';
    
    function initResponsibleFilter() {
        const searchInput = document.getElementById('responsibleSearch');
        const searchButton = document.getElementById('searchButton');
        const select = document.getElementById('responsibleSelect');
        const resultsContainer = document.getElementById('responsibleResults');
        
        if (!searchInput || !searchButton || !select || !resultsContainer) {
            console.log('Elementos no encontrados, reintentando...');
            setTimeout(initResponsibleFilter, 500);
            return;
        }
        
        console.log('✅ Filtro de responsables inicializado');
        
        // Guardar todas las opciones originales
        const allOptions = Array.from(select.options);
        
        // Función para realizar la búsqueda
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            resultsContainer.innerHTML = '';
            
            if (searchTerm === '') {
                // Si no hay término de búsqueda, mostrar todos
                showResults(allOptions.filter(option => option.value !== ""));
                return;
            }
            
            // Filtrar opciones que coincidan
            const matchedOptions = allOptions.filter(option => 
                option.value !== "" && option.text.toLowerCase().includes(searchTerm)
            );
            
            if (matchedOptions.length > 0) {
                showResults(matchedOptions);
            } else {
                resultsContainer.innerHTML = '<div class="p-2 text-muted">No se encontraron resultados</div>';
                resultsContainer.style.display = 'block';
            }
        }
        
        // Función para mostrar resultados
        function showResults(options) {
            resultsContainer.innerHTML = '';
            
            options.forEach(option => {
                const div = document.createElement('div');
                div.className = 'p-2 border-bottom';
                div.style.cursor = 'pointer';
                div.textContent = option.text;
                
                div.addEventListener('click', function() {
                    searchInput.value = option.text;
                    select.value = option.value;
                    resultsContainer.style.display = 'none';
                    
                    // Limpiar mensaje de error
                    const errorDiv = document.getElementById('responsible_error');
                    if (errorDiv) errorDiv.textContent = '';
                });
                
                div.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                
                div.addEventListener('mouseout', function() {
                    this.style.backgroundColor = '';
                });
                
                resultsContainer.appendChild(div);
            });
            
            resultsContainer.style.display = 'block';
        }
        
        // Event listeners
        searchButton.addEventListener('click', performSearch);
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
        
        // Ocultar resultados al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchButton.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
        
        // Validación del formulario
        const form = document.getElementById('movementForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (select.value === "") {
                    e.preventDefault();
                    const errorDiv = document.getElementById('responsible_error');
                    if (errorDiv) {
                        errorDiv.textContent = 'Debe seleccionar un responsable';
                    }
                }
            });
        }
    }

    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initResponsibleFilter);
    } else {
        setTimeout(initResponsibleFilter, 100);
    }
    
    // También inicializar cuando el modal se muestre
    if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
        jQuery('#newMovementModal').on('shown.bs.modal', function() {
            setTimeout(initResponsibleFilter, 100);
        });
    }
})();
</script>

@endsection