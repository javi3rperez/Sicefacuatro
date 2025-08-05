@extends('solicitud::layouts.masterinstructor')

@section('content')
    <h2 class="text-center">Historial de Solicitudes</h2>

    <div style="width: 90%; margin: 0 auto;">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Materiales</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($solicitudes as $solicitud)
                    <tr>
                        <td>{{ $solicitud->id }}</td>
                        <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @switch($solicitud->status)
                                @case('pendiente') <span class="badge bg-warning">Pendiente</span> @break
                                @case('aprobada') <span class="badge bg-success">Aprobada</span> @break
                                @case('rechazada') <span class="badge bg-danger">Rechazada</span> @break
                                @default <span class="badge bg-secondary">{{ $solicitud->status }}</span>
                            @endswitch
                        </td>
                        <td>
                            <ul>
                                @foreach ($solicitud->materiales as $material)
                                    <li>{{ $material->nombre }} ({{ $material->pivot->cantidad }})</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron solicitudes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $solicitudes->links() }}
    </div>
@endsection
