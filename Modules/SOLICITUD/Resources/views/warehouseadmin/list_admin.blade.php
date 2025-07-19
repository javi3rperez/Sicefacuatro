@extends('solicitud::layouts.master')

@section('content')
<br>
<div class="container-fluid">
    <h2 class="mb-4">Listado de Solicitud</h2>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('solicitud.admin.list') }}" class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Filtrar por nombre" value="{{ request('name') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" name="program" class="form-control" placeholder="Filtrar por programa" value="{{ request('program') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('solicitud.admin.list') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card">
        <div class="card-body">
            @if(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            @if($list->isEmpty())
                <div class="alert alert-info">No se encontraron solicitudes</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Programa</th>
                                <th>Fecha/Hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['program'] }}</td>
                                <td>{{ $item['date'] }}</td>
                                <td>
                                    <a href="{{ route('solicitud.formato', ['id' => $item['id']]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-3">
                    {{ $list->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection