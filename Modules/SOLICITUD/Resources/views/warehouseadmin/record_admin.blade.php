@extends('solicitud::layouts.master')

@section('content')
<br>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success font-weight-bold">
            <i class=""></i>Registro de Solicitudes
        </h2>
             <div class="p-2 border-b">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Estado</label>
                    <select class="w-full p-2 border rounded">
                        <option>Todas</option>
                        <option>Aprobadas</option>
                        <option>Rechazadas</option>
                        <option>Pendientes</option>
                    </select>
                    
            </div>
             <div class="p-2">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Fecha</label>
                    <input type="date" class="w-full p-2 border rounded">
            </div>
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
                    <th class="py-3 align-middle border-0 font-weight-light">Persona quien aprobo</th>
                </tr>
                </thead>
        <tbody>
            @foreach($record as $item)
          <tr class="border-bottom">
                <td class="px-4 py-2 font-weight-bold text-dark">{{ $item['id'] }}</td>
                <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-success mr-3">
                                        <i class="fas fa-tag text-success"></i>
                                    </div>
                                    <span></span>
                                </div>
                            </td>
                             <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <span>{{ $item['Solicitud'] }}</span>
                                </div>
                            </td>
                             <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light-primary mr-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <span>{{ $item['Estado'] }}</span>
                                </div>
                            </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-light-info mr-3">
                                            <i class="fas fa-phone text-info"></i>
                                        </div>
                                        <span>Justin Biber</span>
                                    </div>
                                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection