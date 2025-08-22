@extends('solicitud::layouts.masterstore')

@section('content')
<div class="container mt-5">
    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-lg rounded mb-5">
        <div class="card-body text-center py-5">
            <div class="mb-2">
                <i class="fas fa-user-tie fa-4x" style="color: #218838;"></i>
            </div>
            <h1 class="display-4 font-weight-bold text-dark">¡Bienvenido!</h1>
            <hr class="w-50 mx-auto my-2">
            <p class="lead text-secondary">Estás ingresando como <span class="text-success font-weight-bold">Almacenista</span></p>
        </div>
    </div>

    <!-- Estadísticas del Mes -->
    <div class="row mb-2">
        <div class="col-md-6 mb-4">
            <div class="card border-success shadow h-100">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-arrow-circle-down mr-2"></i>Entradas del Mes</h5>
                    <span class="badge badge-light">Octubre 2023</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="border rounded p-3 text-center">
                                <h3 class="text-success font-weight-bold">15</h3>
                                <small class="text-muted">Total Entradas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3 text-center">
                                <h3 class="text-success font-weight-bold">245</h3>
                                <small class="text-muted">Items Ingresados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-success shadow h-100">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-arrow-circle-up mr-2"></i>Salidas del Mes</h5>
                    <span class="badge badge-light">Octubre 2023</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="border rounded p-3 text-center">
                                <h3 class="text-success font-weight-bold">22</h3>
                                <small class="text-muted">Total Salidas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3 text-center">
                                <h3 class="text-success font-weight-bold">187</h3>
                                <small class="text-muted">Items Retirados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.6em;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        background-color: #f8f9fa;
    }
    .table td {
        vertical-align: middle;
    }
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
</style>
@endsection