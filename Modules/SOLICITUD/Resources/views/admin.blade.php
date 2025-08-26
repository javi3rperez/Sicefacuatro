@extends('solicitud::layouts.master')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Solicitudes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .welcome-card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            border-radius: 12px;
            transition: all 0.3s;
            border: none;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        .stat-number {
            font-weight: 700;
            color: #2c3e50;
        }
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #218838, #20c997);
            border-radius: 2px;
        }
        .chart-row {
            margin-top: 40px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Tarjeta de Bienvenida (código original) -->
        <div class="card border-0 shadow-lg rounded">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-user-tie fa-4x" style="color: #218838;"></i>
                </div>
                <h1 class="display-4 font-weight-bold text-dark">¡Bienvenido!</h1>
                <hr class="w-50 mx-auto my-4">
                <p class="lead text-secondary">
                    Estás ingresando como <span class="text-success font-weight-bold">Administrador</span>
                </p>
            </div>
        </div>
        
    
        <!-- Nuevos gráficos añadidos (sin modificar el código anterior) -->
        <div class="row chart-row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="text-center text-success mb-4">Distribución de Solicitudes</h5>
                        <div class="chart-container">
                            <canvas id="donutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="text-center text-primary mb-4">Comparación por Estado</h5>
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos para los gráficos (usando las variables de Blade)
            const approved = {{ $approved }};
            const rejected = {{ $rejected }};
            const pending = {{ $pending }};
            const total = approved + rejected + pending;
            
            // Gráfico de donut
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Aprobadas', 'Rechazadas', 'Pendientes'],
                    datasets: [{
                        data: [approved, rejected, pending],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(220, 53, 69, 0.8)',
                            'rgba(255, 193, 7, 0.8)'
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)',
                            'rgba(255, 193, 7, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percentage = Math.round((value / total) * 100);
                                    return `${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Gráfico de barras
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Aprobadas', 'Rechazadas', 'Pendientes'],
                    datasets: [{
                        label: 'Cantidad de Solicitudes',
                        data: [approved, rejected, pending],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.7)',
                            'rgba(220, 53, 69, 0.7)',
                            'rgba(255, 193, 7, 0.7)'
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)',
                            'rgba(255, 193, 7, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
@endsection