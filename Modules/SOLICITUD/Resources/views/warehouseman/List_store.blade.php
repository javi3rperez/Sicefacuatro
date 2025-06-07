@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container mt-5">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class=""></i>listado de solicitud
        </h2>
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
                            <th class="py-3 align-middle border-0 font-weight-light">Listado de Solicitud</th>
                            <th class="py-3 align-middle border-0 font-weight-light">Estado</th>
                            <th class="py-3 align-middle border-0 font-weight-light">Acciones</th>
                            
                        </tr>
             </thead>
            <tbody>
                @foreach($list as $solicitud)
                <tr>
                    <td>{{ $solicitud['id'] }}</td>
                    <td>Solicitud</td> <!-- Ejemplo de campo para mostrar -->
                    <td>Aceptado</td>
                    <td>
                        <a href="" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection