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
                <option value="Insumos">Insumos</option>
            </select>

            <select id="categoriaFiltro" class="form-select">
                <option value="">Categorías</option>
                <option value="Clavos">Clavos</option>
                <option value="Tornillos">Tornillos</option>
                <option value="Herramientas">Herramientas</option>
                <option value="Cuadernos">Cuadernos</option>
                <option value="Lápices">Lápices</option>
                <option value="Marcadores">Marcadores</option>
                <option value="Jabón">Jabón</option>
                <option value="Cloro">Cloro</option>
                <option value="Papel Higiénico">Papel Higiénico</option>
                <option value="Bolsas">Bolsas</option>
                <option value="Guantes">Guantes</option>
                <option value="Cajas">Cajas</option>
            </select>
        </div>
    </div>

    <table class="inventario-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lotes</th>
                <th>Categorías</th>
                <th>Productos</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody id="inventarioBody">
            @foreach($inventory as $item)
            <tr data-lote="{{ $item['lote'] }}" data-categoria="{{ $item['categoria'] }}">
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['lote'] }}</td>
                <td>{{ $item['categoria'] }}</td>
                <td>{{ $item['producto'] }}</td>
                <td>{{ $item['cantidad'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.getElementById('loteFiltro').addEventListener('change', filtrarTabla);
    document.getElementById('categoriaFiltro').addEventListener('change', filtrarTabla);

    function filtrarTabla() {
        const loteFiltro = document.getElementById('loteFiltro').value.toLowerCase();
        const categoriaFiltro = document.getElementById('categoriaFiltro').value.toLowerCase();

        const filas = document.querySelectorAll('#inventarioBody tr');

        filas.forEach(fila => {
            const lote = fila.getAttribute('data-lote').toLowerCase();
            const categoria = fila.getAttribute('data-categoria').toLowerCase();

            const mostrar =
                (loteFiltro === "" || lote === loteFiltro) &&
                (categoriaFiltro === "" || categoria === categoriaFiltro);

            fila.style.display = mostrar ? "" : "none";
        });
    }
</script>
@endsection
