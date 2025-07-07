@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container mt-4">
    <!-- Filtros mejorados -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('solicitud.store.evidence') }}" class="row">
                <div class="form-group col-md-3">
                    <label for="filterCategory">Categoría:</label>
                    <select class="form-control form-control-sm" id="filterCategory" name="category_id">
                        <option value="">Todas</option>
                        
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="filterProduct">Producto:</label>
                    <input type="text" class="form-control form-control-sm" id="filterProduct" name="product_name" 
                           placeholder="Nombre producto" value="{{ request('product_name') }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="filterMovement">Tipo Mov.:</label>
                    <select class="form-control form-control-sm" id="filterMovement" name="movement_type">
                        <option value="">Todos</option>
                        <option value="entry" {{ request('movement_type') == 'entry' ? 'selected' : '' }}>Entrada</option>
                        <option value="exit" {{ request('movement_type') == 'exit' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
                <div class="form-group col-md-3 align-self-end">
                    <button type="submit" class="btn btn-success btn-sm btn-block">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de evidencias -->
    <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary font-weight-bold">
                    <i class="fas fa-list-alt mr-2 text-success"></i> Registro de Evidencias
                </h5>
                <a href="#" class="btn btn-success btn-lg shadow-sm" data-toggle="modal" data-target="#addEvidenceModal">
                    <i class="fas fa-plus mr-2"></i>Agregar Evidencia
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th class="py-3 align-middle">ID</th>
                            <th class="py-3 align-middle">Categoría</th>
                            <th class="py-3 align-middle">Producto</th>
                            <th class="py-3 align-middle">Tipo Mov.</th>
                            <th class="py-3 align-middle">Evidencia</th>
                            <th class="py-3 align-middle">Comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evidence as $evidencia)
                        <tr>
                            <td class="align-middle font-weight-bold">{{ $evidencia->id }}</td>
                            <td class="align-middle">
                                {{ $evidencia->category_id }}
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
                                @else
                                    <span class="badge badge-danger">Salida</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($evidencia->evidence_path)
                                    <a href="{{ Storage::url($evidencia->evidence_path) }}" target="_blank" 
                                       class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Ver evidencia">
                                        <i class="fas fa-file-image"></i> Ver
                                    </a>
                                @else
                                    <span class="text-muted">Sin evidencia</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ Str::limit($evidencia->comments, 50) }}
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
        {{ $evidence->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal para Agregar Evidencia (se mantiene igual) -->
@endsection

@section('scripts')
<script>
$(function () {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Mantener parámetros de filtro en la paginación
    $('.pagination a').each(function() {
        let href = $(this).attr('href');
        if (href) {
            let url = new URL(href);
            @foreach(request()->query() as $key => $value)
                url.searchParams.set('{{ $key }}', '{{ $value }}');
            @endforeach
            $(this).attr('href', url.toString());
        }
    });
});
</script>
@endsection