@extends('solicitud::layouts.masterleader')

@section('content')
<style>
    .container-xl-custom {
        max-width: 1200px;
        margin: auto;
        padding: 2rem 1rem;
    }

    .card-elevated {
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
    }

    .title-section {
        font-size: 2.2rem;
        font-weight: 700;
        color: #34495e;
    }

    .filter-select {
        width: 260px;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 1rem;
    }

    .table-custom thead th {
        background-color: #f0f2f5;
        font-weight: 700;
        text-align: center;
        padding: 1rem;
        color: #2c3e50;
        border-bottom: 2px solid #dee2e6;
    }

    .table-custom tbody td {
        background-color: #ffffff;
        border: none;
        padding: 1rem;
        vertical-align: middle;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04);
    }

    .table-custom td:first-child {
        border-top-left-radius: 0.75rem;
        border-bottom-left-radius: 0.75rem;
    }

    .table-custom td:last-child {
        border-top-right-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
    }

    .badge-status {
        font-size: 0.85rem;
        padding: 0.4em 0.9em;
        border-radius: 0.6rem;
        font-weight: 600;
        display: inline-block;
        text-transform: capitalize;
    }

    .badge-pendiente { background-color: #fff6db; color: #b68600; }
    .badge-aceptada  { background-color: #e1f5e8; color: #1d8144; }
    .badge-rechazada { background-color: #fce4e4; color: #c0392b; }

    .btn-action {
        border: none;
        background: none;
        font-size: 1.2rem;
        color: #6c757d;
        margin: 0 0.3rem;
        transition: 0.2s ease;
    }

    .btn-action:hover {
        color: #007bff;
        transform: scale(1.15);
    }

    .modal-content {
        border-radius: 1rem;
    }

    .no-data-row td {
        background-color: transparent !important;
        text-align: center;
        color: #6c757d;
        font-style: italic;
        padding: 2rem;
    }

    @media (max-width: 768px) {
        .filter-select {
            width: 100%;
            margin-top: 1rem;
        }
    }
</style>

<div class="container-xl-custom">
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h2 class="title-section mb-3 mb-md-0"> Historial de Solicitudes</h2>
            <form method="GET" action="{{ route('solicitud.leader.index') }}">
                <select name="estado" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptadas</option>
                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazadas</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                </select>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Detalle</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id }}</td>
                            <td class="text-start">
                                {{ $solicitud->batch ?? '---' }} |
                                {{ $solicitud->product ?? '---' }} |
                                {{ $solicitud->quantity ?? '0' }}
                            </td>
                            <td>{{ $solicitud->created_at->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge-status badge-{{ $solicitud->estado }}">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn-action" data-bs-toggle="modal" data-bs-target="#editModal{{ $solicitud->id }}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('solicitud.leader.destroy', $solicitud->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta solicitud?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action text-danger" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal de edición -->
<div class="modal fade" id="editModal{{ $solicitud->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $solicitud->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('solicitud.leader.update', $solicitud->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Solicitud #{{ $solicitud->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ $solicitud->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Programa</label>
                        <input type="text" name="program" class="form-control" value="{{ $solicitud->program }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lote</label>
                        <input type="text" name="batch" class="form-control" value="{{ $solicitud->batch }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <input type="text" name="product" class="form-control" value="{{ $solicitud->product }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="quantity" class="form-control" value="{{ $solicitud->quantity }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="date" class="form-control" value="{{ $solicitud->created_at->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="pendiente" {{ $solicitud->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aceptada" {{ $solicitud->estado == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                            <option value="rechazada" {{ $solicitud->estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

                    @empty
                        <tr class="no-data-row">
                            <td colspan="5">No hay solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
