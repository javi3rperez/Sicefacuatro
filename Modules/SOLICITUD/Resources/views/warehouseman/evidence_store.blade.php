@extends('solicitud::layouts.masterstore')

@section('content')
    <div class="container-fluid py-5">
        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i> Por favor corrige los siguientes errores:
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    
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
                            <th class="py-2 small font-weight-bold text-uppercase">Cantidad</th>
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
<td>
    @if($item->evidence_path)
        @if(Str::endsWith($item->evidence_path, ['.jpg', '.jpeg', '.png', '.gif']))
            <img src="{{ asset('storage/'.$item->evidence_path) }}" alt="Evidencia" class="img-thumbnail" width="120">
        @elseif(Str::endsWith($item->evidence_path, '.pdf'))
            <a href="{{ asset('storage/'.$item->evidence_path) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-file-pdf"></i> Ver PDF
            </a>
        @else
            <a href="{{ asset('storage/'.$item->evidence_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-download"></i> Descargar
            </a>
        @endif
    @else
        <span class="text-muted">Sin evidencia</span>
    @endif
</td>


                            <td class="py-2">{{ $item->comments ?? 'Ninguno' }}</td>

                            <td class="align-middle text-center">
                                <span class="badge badge-info">
                                    {{ $item->quantity }}
                                </span>
                            </td>

                            <!-- 👇 Aquí la fecha con formato día/mes/año hora:minuto -->
                            <td class="align-middle">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No hay evidencias registradas</td>
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
<!-- Modal para Ver Evidencia -->
<div class="modal fade" id="viewEvidenceModal" tabindex="-1" role="dialog" aria-labelledby="viewEvidenceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="viewEvidenceModalLabel">
          <i class="fas fa-image mr-2"></i> Evidencia
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="evidenceImage" src="" alt="Evidencia" class="img-fluid rounded shadow">
        <div class="mt-3">
          <a id="downloadEvidence" href="#" download class="btn btn-outline-success">
            <i class="fas fa-download mr-1"></i> Descargar
          </a>
        </div>
      </div>
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
                                <select class="form-control border-success" id="element_id" name="element_id" required>
                                    <option value="">Seleccione Producto</option>
                                    @foreach($elements as $element)
                                        <option value="{{ $element->id }}">{{ $element->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success font-weight-bold">Cantidad</label>
                                <input type="number" class="form-control border-success" name="amount" min="1" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Tipo de Movimiento</label>
                                <select class="form-control border-success" id="movement_type" name="movement_type" required>
                                    <option value="exit" selected>Salida</option>
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
    <style>
        /* Estilos generales */
        .badge-success {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
            font-weight: 600;
        }
        .badge-warning {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            font-weight: 600;
        }
        .badge-primary {
            background-color: rgba(0, 123, 255, 0.2);
            color: #007bff;
            font-weight: 600;
        }
        .badge-secondary {
            background-color: rgba(108, 117, 125, 0.2);
            color: #6c757d;
            font-weight: 600;
        }
        .badge-info {
            background-color: rgba(23, 162, 184, 0.2);
            color: #17a2b8;
            font-weight: 600;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.05);
        }
        .page-item.active .page-link {
            background-color: #28a745;
            border-color: #28a745;
        }
        .page-link {
            color: #28a745;
        }
        .page-link:hover {
            color: #1e7e34;
        }
        .rounded-lg {
            border-radius: 0.5rem !important;
        }
        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }
        .border-success {
            border-color: #28a745 !important;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .bg-success {
            background-color: #28a745 !important;
        }
        .text-success {
            color: #28a745 !important;
        }
        .alert-success {
            background-color: rgba(40, 167, 69, 0.15);
            border-color: rgba(40, 167, 69, 0.2);
            color: #155724;
        }
        
        /* Estilos específicos para la tabla de evidencias */
        .evidence-table thead th {
            vertical-align: middle;
            padding: 12px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        
        .evidence-table tbody td {
            vertical-align: middle;
            padding: 12px 15px;
        }
        
        /* Estilos para la paginación */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        
        /* Estilos para los botones de acción */
        .btn-outline-success {
            color: #28a745;
            border-color: #28a745;
        }
        
        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }
        
        /* Estilos para el modal */
        .modal-content {
            border: 1px solid #28a745;
            border-radius: 0.5rem;
        }
        
        .modal-header {
            background-color: #28a745;
            color: white;
            border-bottom: 1px solid #28a745;
        }
        
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        
        .custom-file-input:focus ~ .custom-file-label {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        
        .custom-file-label::after {
            background-color: #e9ecef;
            color: #495057;
        }
    </style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Mostrar nombre de archivo en input file
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    $(document).ready(function() {
    // Mostrar nombre de archivo en input file
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Cargar imagen en el modal al dar click en "Ver"
    $('.view-evidence-btn').on('click', function() {
        let imgSrc = $(this).data('img');
        $('#evidenceImage').attr('src', imgSrc);
        $('#downloadEvidence').attr('href', imgSrc);
    });
});
</script>
@endsection