@extends('solicitud::layouts.master') 

@section('content')
<br>
<div class="container mt-5">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-clipboard-list"></i> Listado de Solicitudes
        </h2>
           
        <form method="GET" action="" class="p-2">
            <div class="d-flex align-items-end gap-3">
            <!-- Filtro por Nombre del Responsable -->
            <div>
                <label class="form-label text-gray-700 text-sm mb-1 d-block">Nombre del Responsable</label>
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                    <input type="text" 
                           name="nombre" 
                           class="form-control border-start-0"
                           value="{{ $nombre_seleccionado ?? '' }}" 
                           placeholder="Buscar responsable">
                </div>
            </div>
            
            <!-- Filtro por Fecha de Solicitud -->
            <div>
                <label class="form-label text-gray-700 text-sm mb-1 d-block">Fecha Solicitud</label>
                <input type="date" 
                       name="fecha" 
                       class="form-control"
                       value="{{ $fecha_seleccionada ?? '' }}"
                       style="width: 170px;">
            </div>
            
            <!-- Botón de Filtro -->
            <button type="submit" class="btn btn-success ">
                <i class="fas fa-filter"></i> Filtrar
            </button>
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
                    <th class="py-3 align-middle border-0 font-weight-light">ID</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Nombre del Responsable</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Fecha de Solicitud</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Acciones</th>                
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
                 <tr class="border-bottom">
                      <td class="align-middle font-weight-bold text-dark">{{ $item->id }}</td>
                        <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-3">
                                        <i class="fas fa-user-tie text-success"></i>
                                    </div>
                                    <span>{{ $item->accountable_name ?? 'Sin responsable' }}</span>
                                </div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-light-primary mr-3">
                                    <i class="fas fa-calendar-day text-primary"></i>
                                </div>
                                <span>
                                    @if($item->request_date)
                                        {{ \Carbon\Carbon::parse($item->request_date)->format('d/m/Y') }}
                                    @else
                                        Sin fecha
                                    @endif
                                </span>
                            </div>
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('solicitud.admin.request', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <br>
                        No se encontraron solicitudes
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Paginación -->
        @if($list->count())
        <div class="mt-4 d-flex justify-content-center">
            {{ $list->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
