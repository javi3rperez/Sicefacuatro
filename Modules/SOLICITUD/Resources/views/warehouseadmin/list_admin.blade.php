@extends('solicitud::layouts.master')

@section('content')
<br>
<div class="container mt-5">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class="fas fa-clipboard-list"></i> Listado de Solicitud
        </h2>
           
        <form method="GET" action="" class="p-2">
            <div class="d-flex align-items-end gap-3">
            <!-- Filtro por Nombre -->
            <div>
                <label class="form-label text-gray-700 text-sm mb-1 d-block">Nombre</label>
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           name="nombre" 
                           class="form-control border-start-0"
                           value="{{ request('nombre') }}" 
                           placeholder="Buscar solicitante">
                </div>
            </div>
            
            <!-- Filtro por Fecha -->
            <div>
                <label class="form-label text-gray-700 text-sm mb-1 d-block">Fecha</label>
                <input type="date" 
                       name="fecha" 
                       class="form-control"
                       value="{{ request('fecha') }}"
                       style="width: 150px;">
            </div>
            
            <!-- Botón de Filtro -->
            <button type="submit" class="btn btn-success h-100">
                <i class="fas fa-filter"></i>
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
                    <th class="py-3 align-middle border-0 font-weight-light">Solicitante</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Programa</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Fecha/Hora</th>
                    <th class="py-3 align-middle border-0 font-weight-light">Acciones</th>                
                </tr>
            </thead>
            <tbody>
                @foreach($list as $item)
                 <tr class="border-bottom">
                      <td class="align-middle font-weight-bold text-dark">{{ $item->id }}</td>
                        <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-3">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                    <span>{{ $item->name }}</span>
                                </div>
                        </td>
                        <td class="align-middle">
                            {{ $item->program }}
                        </td>
                         <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                    <span>{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                        </td>
                         <td>
                        <a href="" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Paginación -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $list->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection