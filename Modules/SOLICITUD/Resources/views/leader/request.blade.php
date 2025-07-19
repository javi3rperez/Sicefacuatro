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

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('solicitud.leader.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="program">Programa</label>
            <input type="text" name="program" id="program" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="batch">Lote</label>
            <input type="text" name="batch" id="batch" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="product">Producto</label>
            <input type="text" name="product" id="product" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="quantity">Cantidad</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required min="1">
        </div>

        <div class="form-group">
            <label for="date">Fecha</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Solicitar</button>
    </form>
</div>
@endsection
