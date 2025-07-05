@extends('solicitud::layouts.masterleader') 

@section('content')
<style>
    .inventario-container {
        padding: 2rem;
        background-color: #fff;
    }

    .inventario-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .inventario-title {
        color: #28a745; /* Verde SENA */
        font-weight: bold;
        margin-right: 2rem;
    }

    .inventario-filtros {
        display: flex;
        gap: 1rem;
    }
    .form-control {
    padding: 0.4rem;
    border-radius: 4px;
    border: 1px solid #ced4da;
}

    .form-select {
        padding: 0.4rem;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .inventario-table {
        width: 100%;
        border-collapse: collapse;
    }

    .inventario-table th,
    .inventario-table td {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        text-align: center;
        vertical-align: middle;
    }

    .inventario-table th {
        background-color: #f8f9fa;
    }

    .inventario-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="inventario-container">
    <div class="inventario-header">
        <h2 class="inventario-title">Inventario Bodega</h2>

        <div class="inventario-filtros">
            <select id="loteFiltro" class="form-select">
                <option value="">Lotes</option>
                <option value="Ferreteria">Ferretería</option>
                <option value="Papeleria">Papelería</option>
                <option value="Higiene">Higiene</option>
            </select>

            <!-- Campo de fecha en lugar de categoría -->
            <input type="date" id="fechaFiltro" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
    </div>

    <table class="inventario-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lotes</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody id="inventarioBody">
            @foreach($inventory as $item)
            <tr data-lote="{{ $item['lote'] }}" data-fecha="{{ $item['fecha'] }}">
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['lote'] }}</td>
                <td>{{ $item['producto'] }}</td>
                <td>{{ $item['cantidad'] }}</td>
                <td>{{ $item['fecha'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.getElementById('loteFiltro').addEventListener('change', filtrarTabla);
    document.getElementById('fechaFiltro').addEventListener('change', filtrarTabla);

    function filtrarTabla() {
        const loteFiltro = document.getElementById('loteFiltro').value.toLowerCase();
        const fechaFiltro = document.getElementById('fechaFiltro').value;

        const filas = document.querySelectorAll('#inventarioBody tr');

        filas.forEach(fila => {
            const lote = fila.getAttribute('data-lote').toLowerCase();
            const fecha = fila.getAttribute('data-fecha');

            const mostrar =
                (loteFiltro === "" || lote === loteFiltro) &&
                (fechaFiltro === "" || fecha === fechaFiltro);

            fila.style.display = mostrar ? "" : "none";
        });
    }
</script>
@endsection
