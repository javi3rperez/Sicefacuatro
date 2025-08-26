@extends('solicitud::layouts.masterleader')

@section('content')

<title>Movimientos de Inventario</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }
    header {
        padding: 15px;
        background-color: white;
        border-bottom: 1px solid #ddd;
    }
    .container {
        padding: 20px;
    }
    h2 {
        color: #28a745;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #28a745;
    }
    .card-header {
        background-color: #28a745;
        padding: 10px;
        color: white;
        font-weight: bold;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .badge {
        background-color: #d4edda;
        color: #155724;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 0.9em;
    }
    .empty-message {
        text-align: center;
        color: #6c757d;
        padding: 15px;
    }
</style>

 {{-- Tarjeta de bienvenida --}}
    <div class="card border-0 shadow-lg rounded mb-5">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-box fa-3x text-success"></i>
            </div>
            <h1 class="display-6 fw-bold">Movimientos de Bienes</h1>
            <p class="text-muted">Consulta los movimientos relacionados con tus solicitudes de bienes.</p>
        </div>
    </div>

    {{-- Tabla de movimientos --}}
    <div class="card border-0 shadow-lg rounded">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Historial de Movimientos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tipo de Movimiento</th>
                            <th>Elemento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->id }}</td>
                                <td>{{ $movimiento->movementType->name ?? 'Sin tipo' }}</td>
                                <td>
                                    @forelse($movimiento->request->items as $item)
                                        <div>- {{ $item->item_description }}</div>
                                    @empty
                                        Sin elemento
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No hay movimientos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($movimientos->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $movimientos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

