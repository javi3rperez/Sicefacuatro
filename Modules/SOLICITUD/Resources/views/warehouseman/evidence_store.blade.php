@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container-fluid py-5">
    <!-- Título principal -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-clipboard-check mr-2"></i> Evidencia de Entrega
        </h2>
        <button class="btn btn-success" data-toggle="modal" data-target="#addEvidenceModal">
            <i class="fas fa-plus mr-2"></i> Agregar Evidencia
        </button>
    </div>

    <!-- Tabla de evidencias -->
    <div class="card border-success shadow">
        <div class="card-header bg-success text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-list-alt mr-2"></i> Registro de Evidencias
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="py-2 small font-weight-bold text-uppercase">ID</th>
                            <th class="py-2 small font-weight-bold text-uppercase">Categoría</th>
                            <th class="py-2 small font-weight-bold text-uppercase">Producto</th>
                            <th class="py-2 small font-weight-bold text-uppercase">Tipo Mov.</th>
                            <th class="py-2 small font-weight-bold text-uppercase">Evidencia</th>
                            <th class="py-2 small font-weight-bold text-uppercase">Comentarios</th>
                            <th class="py-2 small font-weight-bold text-uppercase">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evidence as $item)
                        <tr>
                            <td class="py-2">{{ $item->id }}</td>
                            <td class="py-2">{{ $item->category_name }}</td>
                            <td class="py-2">{{ $item->product_name }}</td>
                            <td class="py-2">
                                @if($item->movement_type == 'entry')
                                    <span class="badge badge-primary">Entrada</span>
                                @else
                                    <span class="badge badge-warning">Salida</span>
                                @endif
                            </td>
                            <td class="py-2">
                                @if($item->evidence_path)
                                <a href="{{ asset('storage/'.$item->evidence_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye mr-1"></i> Ver
                                </a>
                                @else
                                <span class="text-muted">Sin evidencia</span>
                                @endif
                            </td>
                            <td class="py-2">{{ $item->comments ?? 'Ninguno' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay evidencias registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $evidence->links() }}
        </div>
    </div>
</div>

<!-- Modal para Agregar Evidencia -->
<div class="modal fade" id="addEvidenceModal" tabindex="-1" role="dialog" aria-labelledby="addEvidenceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addEvidenceModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i> Agregar Nueva Evidencia
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('solicitud.store.evidence.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Categoría</label>
                                <select class="form-control border-success" id="category_id" name="category_id" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Producto</label>
                                <input type="text" class="form-control border-success" id="product_name" name="product_name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Tipo de Movimiento</label>
                                <select class="form-control border-success" id="movement_type" name="movement_type" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="entry">Entrada</option>
                                    <option value="exit">Salida</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Evidencia (Imagen)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input border-success" id="evidence" name="evidence" accept="image/*" required>
                                    <label class="custom-file-label text-success" for="evidence">Seleccione un archivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-success">Comentarios</label>
                        <textarea class="form-control border-success" id="comments" name="comments" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>Guardar Evidencia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Mostrar nombre de archivo en input file
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endsection