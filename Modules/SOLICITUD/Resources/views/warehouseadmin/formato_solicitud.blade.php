<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formato de Solicitud</title>
    <style>
        /* Tus estilos CSS aquí (los mismos que ya tenías) */
        body { font-family: Arial; margin: 0; padding: 20px; }
        .document { max-width: 800px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; }
        /* ... */
    </style>
</head>
<body>
<div class="document"> 
    <div class="header">
        <img src="{{ asset('logo_sena.png') }}" alt="Logo SENA" style="height: 50px; width: 90px;">
        <div style="text-align: right; font-size: 13px;">
            <strong>Versión:</strong> 06<br>
            <strong>Código:</strong> GIL-F-014
        </div>
        <h3 style="font-size: 12px; font-weight: bold; text-transform: uppercase;">
            <strong>PROCESO GESTIÓN DE INFRAESTRUCTURA Y LOGÍSTICA</strong><br>
            <strong>FORMATO SOLICITUD DE BIENES PARA USO DE CUENTADANTES</strong>
        </h3>
    </div>

    <table>
        <tr>
            <td><strong>FECHA SOLICITUD:</strong> {{ $fecha }}</td>
            <td><strong>ÁREA:</strong> {{ $solicitud->program }}</td>
            <td><strong>CÓDIGO REGIONAL:</strong> 41</td>
            <td><strong>NOMBRE REGIONAL:</strong> Huila</td>
        </tr>
        <!-- Resto de tu tabla... -->
    </table>
    <!-- Resto de tu formato... -->
</div>

<div class="text-center mt-4">
    <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
    <a href="{{ route('solicitud.admin.list') }}" class="btn btn-secondary">Volver</a>
</div>
</body>
</html>