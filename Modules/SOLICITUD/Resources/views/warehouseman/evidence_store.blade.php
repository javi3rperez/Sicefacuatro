@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-clipboard-check"></i> Evidencia de Entrega
        </h2>
        <a href="#" class="btn btn-success btn-lg shadow-sm" data-toggle="modal" data-target="#addEvidenceModal">
            <i class="fas fa-plus mr-2"></i>Agregar Evidencia
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

    <!-- Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('solicitud.store.evidence') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label for="filterLot" class="mr-2">Lote:</label>
                    <input type="text" class="form-control form-control-sm" id="filterLot" name="lot" placeholder="N° Lote" value="{{ request('lot') }}">
                </div>
                <div class="form-group mr-3">
                    <label for="filterProduct" class="mr-2">Producto:</label>
                    <input type="text" class="form-control form-control-sm" id="filterProduct" name="product" placeholder="Nombre producto" value="{{ request('product') }}">
                </div>
                <div class="form-group mr-3">
                    <label for="filterMovement" class="mr-2">Tipo Mov.:</label>
                    <select class="form-control form-control-sm" id="filterMovement" name="movement_type">
                        <option value="">Todos</option>
                        <option value="entry" {{ request('movement_type') == 'entry' ? 'selected' : '' }}>Entrada</option>
                        <option value="exit" {{ request('movement_type') == 'exit' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 text-secondary font-weight-bold">
                <i class="fas fa-list-alt mr-2 text-success"></i> Registro de Evidencias
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th class="py-3 align-middle">ID</th>
                            <th class="py-3 align-middle">Lote</th>
                            <th class="py-3 align-middle">Producto</th>
                            <th class="py-3 align-middle">Tipo Movimiento</th>
                            <th class="py-3 align-middle">Evidencia</th>
                            <th class="py-3 align-middle">Usuario</th>
                            <th class="py-3 align-middle text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evidence as $evidencia)
                        <tr>
                            <td class="align-middle font-weight-bold">{{ $evidencia->id }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-2">
                                        <i class="fas fa-barcode text-success"></i>
                                    </div>
                                    {{ $evidencia->lot_number }}
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-warning mr-2">
                                        <i class="fas fa-box-open text-warning"></i>
                                    </div>
                                    {{ $evidencia->product_name }}
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($evidencia->movement_type == 'entry')
                                    <span class="badge badge-success">Entrada</span>
                                @elseif($evidencia->movement_type == 'exit')
                                    <span class="badge badge-danger">Salida</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($evidencia->evidence_path)
                                    <a href="{{ asset('storage/'.$evidencia->evidence_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-image"></i> Ver
                                    </a>
                                @else
                                    <span class="text-muted">Sin evidencia</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-info mr-2">
                                        <i class="fas fa-user text-info"></i>
                                    </div>
                                    {{ $evidencia->user_name ?? 'Sistema' }}
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-sm btn-soft-primary rounded-circle mr-1 shadow-sm" title="Editar" data-toggle="modal" data-target="#editEvidenceModal{{ $evidencia->id }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('evidence.destroy', $evidencia->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger rounded-circle shadow-sm" onclick="return confirm('¿Confirmar eliminación de esta evidencia?')" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No se encontraron registros de evidencia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-green">
                @if ($evidence->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $evidence->previousPageUrl() }}" rel="prev">Anterior</a>
                    </li>
                @endif

                @foreach ($evidence->getUrlRange(1, $evidence->lastPage()) as $page => $url)
                    @if ($page == $evidence->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($evidence->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $evidence->nextPageUrl() }}" rel="next">Siguiente</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Siguiente</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<!-- Modal para Agregar Evidencia -->
<div class="modal fade" id="addEvidenceModal" tabindex="-1" role="dialog" aria-labelledby="addEvidenceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="addEvidenceModalLabel">Agregar Nueva Evidencia</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('solicitud.store.evidence') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Formulario de creación aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Evidencia</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(function () {
    // Mantener parámetros de filtro en la paginación
    document.querySelectorAll('.pagination a.page-link').forEach(link => {
        if (link.href) {
            const url = new URL(link.href);
            url.searchParams.set('lot', '{{ request('lot') }}');
            url.searchParams.set('product', '{{ request('product') }}');
            url.searchParams.set('movement_type', '{{ request('movement_type') }}');
            link.href = url.toString();
        }
    });
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
    .pagination-green .page-link {
        color: #397a1f;
        border-color: #d1e7dd;
        transition: all 0.3s;
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
@endsection
@endsection