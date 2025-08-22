<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Movimientos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Movimientos</h2>
        <p>Fecha del reporte: {{ $reportDate }}</p>
        @if($reportType)
            <p>Tipo: {{ $reportType }}</p>
        @endif
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
        <td colspan="5" style="text-align:center;">No se encontraron movimientos para esta fecha</td>
    </tr>
@endforelse
        </tbody>
    </table>

</body>
</html>