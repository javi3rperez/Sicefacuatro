@extends('solicitud::layouts.masterleader') 

@section('content')
<style>
    .historia-container {
        padding: 2rem;
        background-color: #fff;
    }

    .historia-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .titulo-historial {
        color: #28a745; /* Verde SENA */
        font-weight: bold;
        margin-right: 2rem;
    }

    .filtro-estado {
        display: flex;
        gap: 1rem;
    }

    .filtro-select {
        padding: 0.4rem;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .thead-custom {
        background-color: rgb(196, 202, 208);
    }

    .col-ver {
        text-align: center;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
    }

    .table th,
    .table td {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        vertical-align: middle;
    }

    .table th {
        background-color: #f8f9fa;
        text-align: center;
    }

    .table td:nth-child(2) {
        text-align: left;
    }

    .table td:not(:nth-child(2)) {
        text-align: center;
    }
</style>

<div class="historia-container">
    <div class="historia-header">
        <h3 class="titulo-historial">Historial Solicitudes</h3>

        <div class="filtro-estado">
            <select class="form-select filtro-select">
                <option value="">Estado</option>
                <option value="aceptada">Aceptadas</option>
                <option value="rechazada">Rechazadas</option>
                <option value="pendiente">Pendientes</option>
            </select>
        </div>
    </div>

    <table class="table">
        <thead class="thead-custom">
            <tr>
                <th>ID</th>
                <th>Solicitudes</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Ferretería | Herramientas | Machetes | 10</td>
                <td>2025-07-01</td>
                <td style="color: gray;">Aceptada</td>
                <td class="col-ver">
                    <button class="btn btn-warning btn-sm" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Papelería | Instrumentos de escritura | Marcadores | 15</td>
                <td>2025-07-02</td>
                <td style="color: gray;">Rechazada</td>
                <td class="col-ver">
                    <button class="btn btn-warning btn-sm" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
