@extends('solicitud::layouts.masterinstructor')

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
        border: 1px solid #c3e6cb;
    }

    .title-section {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2e7d32;
    }

    .filter-select {
        width: 260px;
        border-radius: 0.5rem;
        font-size: 1rem;
        border: 1px solid #81c784;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 1rem;
    }

    .table-custom thead th {
        background-color: #e8f5e9;
        font-weight: 700;
        text-align: center;
        padding: 1rem;
        color: #1b5e20;
        border-bottom: 2px solid #c8e6c9;
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

    /* Estados con colores */
    .badge-status {
        font-size: 0.85rem;
        padding: 0.4em 0.9em;
        border-radius: 0.6rem;
        font-weight: 600;
        display: inline-block;
        text-transform: capitalize;
    }

    .badge-pendiente { background-color: #fffde7; color: #827717; }
    .badge-aceptada  { background-color: #c8e6c9; color: #1b5e20; }
    .badge-rechazada { background-color: #ffcdd2; color: #b71c1c; }

    .btn-action {
        border: none;
        background: none;
        font-size: 1.2rem;
        color: #388e3c;
        margin: 0 0.3rem;
        transition: 0.2s ease;
    }

    .btn-action:hover {
        color: #1b5e20;
        transform: scale(1.15);
    }

    .btn-action.text-danger {
        color: #c62828;
    }

    .btn-action.text-danger:hover {
        color: #b71c1c;
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
        <!-- Encabezado con filtro -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h2 class="title-section mb-3 mb-md-0">Historial de Solicitudes</h2>
            <form method="GET" action="{{ route('solicitud.instructor.index') }}">
                <select name="estado" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="approved" {{ request('estado') == 'approved' ? 'selected' : '' }}>Aceptadas</option>
                    <option value="rejected" {{ request('estado') == 'rejected' ? 'selected' : '' }}>Rechazadas</option>
                    <option value="pending"  {{ request('estado') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                    <option value="completed" {{ request('estado') == 'completed' ? 'selected' : '' }}>Completadas</option>
                </select>
            </form>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Detalle</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        @php
                            $estados = [
                                'pending'   => ['texto' => 'Pendiente', 'clase' => 'pendiente'],
                                'approved'  => ['texto' => 'Aprobada',  'clase' => 'aceptada'],
                                'rejected'  => ['texto' => 'Rechazada', 'clase' => 'rechazada'],
                                'completed' => ['texto' => 'Completada','clase' => 'aceptada'],
                            ];
                            $estado = $estados[$solicitud->status] 
                                    ?? ['texto' => ucfirst($solicitud->status), 'clase' => 'pendiente'];
                        @endphp

                        <tr>
                            <td>{{ $solicitud->id }}</td>
                            <td>
                                @if($solicitud->items && $solicitud->items->count() > 0)
                                    @foreach($solicitud->items as $item)
                                        <div>- {{ $item->item_description }}</div>
                                    @endforeach
                                @else
                                    <div class="text-muted fst-italic">Sin detalle</div>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($solicitud->request_date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge-status badge-{{ $estado['clase'] }}">
                                    {{ $estado['texto'] }}
                                </span>
                            </td>
                            <td>
                                @if($solicitud->items && $solicitud->items->count() > 0)
                                    @foreach($solicitud->items as $item)
                                        @if($item->observation)
                                            <div class="text-muted">- {{ $item->observation }}</div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-muted fst-italic">Sin observación</div>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('solicitud.instructor.destroy', $solicitud->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta solicitud?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action text-danger" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="no-data-row">
                            <td colspan="6">No hay solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
