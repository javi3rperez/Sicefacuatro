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
    <div class="row justify-content-center mb-2">
        <div class="col-md-10 mb-4">
            <div class="card border-success shadow">
                <div class="card-header bg-success text-white text-center py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2"></i>Estadísticas de Movimientos - {{ $mes_actual }} {{ $anio_actual }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Tarjeta de Entradas -->
                        <div class="col-md-4 mb-4">
                            <div class="card border-success text-center h-100">
                                <div class="card-header bg-success text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-arrow-circle-down mr-2"></i>Entradas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-success font-weight-bold display-4">{{ $entradas->total_entradas ?? 0 }}</h2>
                                    <p class="text-muted mb-0">Movimientos de entrada</p>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfica -->
                        <div class="col-md-4 mb-4">
                            <div class="card border-success text-center h-100">
                                <div class="card-header bg-success text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-pie mr-2"></i>Distribución
                                    </h6>
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <canvas id="movementChart" width="200" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Salidas -->
                        <div class="col-md-4 mb-4">
                            <div class="card border-success text-center h-100">
                                <div class="card-header bg-success text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-arrow-circle-up mr-2"></i>Salidas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-success font-weight-bold display-4">{{ $salidas->total_salidas ?? 0 }}</h2>
                                    <p class="text-muted mb-0">Movimientos de salida</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen comparativo -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-success mb-3">
                                        <i class="fas fa-balance-scale mr-2"></i>Resumen Comparativo
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1">
                                                <span class="font-weight-bold">Total movimientos:</span> 
                                                <span class="badge badge-success">{{ ($entradas->total_entradas ?? 0) + ($salidas->total_salidas ?? 0) }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1">
                                                <span class="font-weight-bold">Diferencia:</span> 
                                                <span class="badge {{ (($entradas->total_entradas ?? 0) - ($salidas->total_salidas ?? 0)) >= 0 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ (($entradas->total_entradas ?? 0) - ($salidas->total_salidas ?? 0)) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('movementChart').getContext('2d');
    
    // Datos para la gráfica
    const entradas = {{ $entradas->total_entradas ?? 0 }};
    const salidas = {{ $salidas->total_salidas ?? 0 }};
    
    // Crear gráfica de donut
    const movementChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Entradas', 'Salidas'],
            datasets: [{
                data: [entradas, salidas],
                backgroundColor: [
                    '#28a745', // Verde para entradas
                    '#dc3545'  // Rojo para salidas
                ],
                borderColor: [
                    '#218838',
                    '#c82333'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });
});
</script>

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
    .display-4 {
        font-size: 2.5rem;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    #movementChart {
        max-width: 200px;
        max-height: 200px;
        margin: 0 auto;
    }
</style>
@endsection