@extends('solicitud::layouts.master')

@section('content')
<br>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class=""></i>Registro de Solicitudes
        </h2>

        {{-- FORMULARIO DE FILTROS --}}
        <form method="GET" action="{{ route('solicitud.admin.record') }}" class="d-flex">
            <div class="p-2 border-b">
                <label class="block text-gray-700 text-sm font-medium mb-1">Estado</label>
                <select name="status" class="w-full p-2 border rounded">
                    <option value="">Todas</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobadas</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazadas</option>
                    <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pendientes</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completadas</option>
                </select>
            </div>

            <div class="p-2">
                <label class="block text-gray-700 text-sm font-medium mb-1">Fecha</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full p-2 border rounded">
            </div>

            <div class="p-2 d-flex align-items-end">
               <button type="submit" class="btn btn-success">
                <i class="fas fa-filter"></i> Filtrar
            </button>
                <a href="{{ route('solicitud.admin.record') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
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

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-gradient-primary text-white">
                    <tr>
                        <th class="py-3 align-middle border-0 font-weight-light">ID</th>
                        <th class="py-3 align-middle border-0 font-weight-light">Solicitante</th>
                        <th class="py-3 align-middle border-0 font-weight-light">Fecha/Hora</th>
                        <th class="py-3 align-middle border-0 font-weight-light">Estado</th>
                        <th class="py-3 align-middle border-0 font-weight-light">quien aprobo/motivo de rechazo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $item)
                        <tr class="border-bottom">
                            <td class="px-4 py-2 font-weight-bold text-dark">{{ $item->id }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-3">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                    <span>{{ $item->accountable_name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                    <span>{{ $item->request_date }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-info-circle text-primary"></i>
                                    </div>
                                    <span class="badge 
                                        @if($item->status == 'approved') badge-success
                                        @elseif($item->status == 'rejected') badge-danger
                                        @elseif($item->status == 'completed') badge-primary
                                        @else badge-warning @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-start">
                                    <div class="icon-circle bg-light-info mr-3">
                                        <i class="fas fa-comment-alt text-info"></i>
                                    </div>
                                    <div>
                                        @if($item->status == 'rejected')
                                            @forelse($item->items as $reqItem)
                                                <div>- {{ $reqItem->observation ?? 'Sin comentario' }}</div>
                                            @empty
                                                <div>Rechazo sin comentario</div>
                                            @endforelse
                                        @elseif($item->status == 'approved')
                                            <div>{{ $item->approved_by_name ?? 'Aprobado (sin responsable)' }}</div>
                                        @else
                                            <div>Sin comentario</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron solicitudes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
