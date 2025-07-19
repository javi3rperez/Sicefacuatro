@extends('solicitud::layouts.masterinstructor')

@section('content')
    <style>
        .historial-container {
            width: 90%;
            margin: 30px auto; /* Centrar el contenido */
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #2e7d32; /* Verde oscuro */
            text-align: center;
            font-weight: bold;
            border-bottom: 3px solid #66bb6a;
            display: inline-block;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            font-size: 1rem;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
        }

        table th {
            background-color: #2e7d32; /* Verde oscuro */
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }

        table tr {
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e8f5e9; /* Verde muy claro */
        }

        .estado-enviada {
            color: #ff9800; /* Naranja */
            font-weight: bold;
        }

        .estado-aceptada {
            color: #2e7d32; /* Verde */
            font-weight: bold;
        }

        .estado-rechazada {
            color: #c62828; /* Rojo */
            font-weight: bold;
        }
    </style>

    <div class="historial-container">
        <h2>Historial de Solicitudes</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $solicitud)
                    <tr>
                        <td>{{ $solicitud->producto->nombre }}</td>
                        <td>{{ $solicitud->cantidad }}</td>
                        <td>
                            @if($solicitud->estado == 'enviada')
                                <span class="estado-enviada">Enviada</span>
                            @elseif($solicitud->estado == 'aceptada')
                                <span class="estado-aceptada">Aceptada</span>
                            @else
                                <span class="estado-rechazada">Rechazada</span>
                            @endif
                        </td>
                        <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
