<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Movimientos</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 20px;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 15px;
        }
        .header-info {
            flex: 1;
        }
        .logo-container {
            text-align: right;
            margin-left: 30px;
        }
        .logo-img {
            max-width: 100px; /* ajusta el ancho máximo */
            height: auto;     /* mantiene proporción */
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #28a745; 
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .report-title {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .report-date {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .report-type {
            margin: 0;
            color: #28a745;
            font-weight: bold;
            font-size: 14px;
        }
        @media print {
            .logo {
                background: #28a745;
                color: white;
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado con logo a la derecha -->
    <div class="header-container">
        <div class="header-info">
            <h2 class="report-title">Reporte de Movimientos</h2>
            <p class="report-date">Fecha del reporte: {{ $reportDate }}</p>
            @if($reportType)
                <p class="report-type">Tipo: {{ $reportType }}</p>
            @endif
        </div>
        
        <div class="logo-container">
            <img src="{{ public_path('imgsoli/logosena.png') }}" alt="Logo" class="logo-img">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo Movimiento</th>
                <th>Cantidad</th>
                <th>Fecha Registro</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                <tr>
                    <td>{{ $movement->product_name }}</td>
                    <td>{{ $movement->movement_type_name }}</td>
                    <td>{{ $movement->amount }}</td>
                    <td>{{ \Carbon\Carbon::parse($movement->registration_date)->format('d/m/Y') }}</td>
                    <td>{{ $movement->first_name }} {{ $movement->first_last_name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 20px; color: #666;">
                        No se encontraron movimientos para esta fecha
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>