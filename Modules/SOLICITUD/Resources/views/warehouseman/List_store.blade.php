@extends('solicitud::layouts.masterstore')

@section('content')
<br>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-clipboard-list"></i> Listado de Solicitudes Aprobadas
        </h2>
        
        <form method="GET" action="{{ route('solicitud.store.list') }}" class="d-flex">
            <div class="p-2 border-b mr-2">
                <label class="block text-gray-700 text-sm font-medium mb-1">Prioridad</label>
                <select name="priority" class="w-full p-2 border rounded" onchange="this.form.submit()">
                    <option value="">Todas las prioridades</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Media</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>
            <div class="p-2 border-b">
                <label class="block text-gray-700 text-sm font-medium mb-1">Fecha</label>
                <input type="date" name="date" class="w-full p-2 border rounded" 
                       value="{{ request('date') }}" onchange="this.form.submit()">
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
                    <th class="py-3 align-middle">Fecha Solicitud</th>
                    <th class="py-3 align-middle">Fecha Requerida</th>
                    <th class="py-3 align-middle">Prioridad</th>
                    <th class="py-3 align-middle">Estado</th>
                    <th class="py-3 align-middle">Acciones</th>                
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
                    <tr class="border-bottom">
                        <td class="align-middle font-weight-bold">{{ $item->id }}</td>
                        <td class="align-middle">
                            {{ $item->person->name ?? 'N/A' }}
                        </td>
                        <td class="align-middle">
                            {{ $item->request_date->format('d/m/Y H:i') }}
                        </td>
                        <td class="align-middle">
                            {{ $item->required_date->format('d/m/Y') }}
                        </td>
                        <td class="align-middle">
                            @if($item->priority == 'high')
                                <span class="badge badge-danger">Alta</span>
                            @elseif($item->priority == 'medium')
                                <span class="badge badge-warning">Media</span>
                            @else
                                <span class="badge badge-success">Baja</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-success">Aprobado</span>
                        </td>
                        <td class="align-middle">
                            <a href="#" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td> 
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No hay solicitudes aprobadas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection