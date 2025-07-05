@extends('solicitud::layouts.masterleader') 

@section('content')
<style>
    .form-container {
        max-width: 400px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .form-container h3 {
        text-align: center;
        font-weight: bold;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-success {
        width: 100%;
        padding: 0.7rem;
        font-weight: bold;
        border-radius: 5px;
    }
</style>

<div class="form-container">
    <h3>Solicitud</h3>
    <form method="GET" action="#">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="programa">Programa</label>
            <input type="text" name="programa" id="programa" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="lote">Lote</label>
            <input type="text" name="lote" id="lote" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="producto">Producto</label>
            <input type="text" name="producto" id="producto" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Solicitar</button>
    </form>
</div>
@endsection
