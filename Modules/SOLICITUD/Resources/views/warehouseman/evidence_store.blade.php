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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2">1</td>
                            <td class="py-2">12</td>
                            <td class="py-2">Marcador</td>
                            <td class="py-2">Sales</td>
                            <td class="py-2">
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye mr-1"></i> Ver
                                </button>
                            </td>
                            <td class="py-2">Ninguno</td>
                        </tr>
                        <!-- Más filas aquí -->
                    </tbody>
                </table>
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
            <div class="modal-body">
                <form id="addEvidenceForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Categoría</label>
                                <select class="form-control border-success" id="category_id" name="category_id" required>
                                    <option value="">Seleccione una categoría</option>
                                    <!-- Opciones de categorías irían aquí -->
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
                                    <input type="file" class="custom-file-input border-success" id="evidence" name="evidence" accept="image/*">
                                    <label class="custom-file-label text-success" for="evidence">Seleccione un archivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-success">Comentarios</label>
                        <textarea class="form-control border-success" id="comments" name="comments" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveEvidenceBtn">
                    <i class="fas fa-save mr-2"></i>Guardar Evidencia
                </button>
            </div>
        </div>
    </div>
</div>

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

@endsection