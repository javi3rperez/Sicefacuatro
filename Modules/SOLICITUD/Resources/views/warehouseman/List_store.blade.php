@extends('solicitud::layouts.masterstore')

@section('content')
<br>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-clipboard-list"></i> Listado de Solicitudes Aprobadas
        </h2>
        
        <form method="GET" action="{{ route('solicitud.store.list') }}" class="d-flex">
            <div class="p-2">
                <label class="block text-gray-700 text-sm font-medium mb-1">Solicitante</label>
                <input type="text" name="name" value="{{ request('name') }}" class="w-full p-2 border rounded" placeholder="Buscar por nombre">
            </div>
            <div class="p-2">
                <label class="block text-gray-700 text-sm font-medium mb-1">Fecha</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full p-2 border rounded">
            </div>
            <div class="p-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <a href="{{ route('solicitud.store.list') }}" class="btn btn-secondary ml-2">Limpiar</a>
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
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-gradient-primary text-white">
                <tr>
                    <th class="py-3 align-middle">ID</th>
                    <th class="py-3 align-middle">Solicitante</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Fecha/Hora</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Estado</th>
                    <th class="py-3 align-middle border-0 font-weight-light text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
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
                        <td class="align-middle text-center">
                            <a href="{{ route('solicitud.warehouseman.request', $item->id) }}" 
                               class="btn btn-primary btn-sm d-block mx-auto">
                                <i class="fas fa-eye"></i> Ver
                            </a>    
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <br>
                            No se encontraron solicitudes
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
