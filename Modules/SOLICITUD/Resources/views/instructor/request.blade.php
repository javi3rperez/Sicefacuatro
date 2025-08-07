@extends('solicitud::layouts.masterinstructor')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h2 class="text-center mb-4">Solicitud</h2>

                    <form method="POST" action="{{ route('solicitud.instructor.request') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nombre del Instructor:</label>
                            <input type="text" name="nombre" class="form-control" value="{{ auth()->user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Programa:</label>
                            <input type="text" name="programa" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lote:</label>
                            <select name="lote_id" class="form-select" required>
                                <option value="">Seleccionar lote</option>
                                @foreach($lotes as $lote)
                                    <option value="{{ $lote->id }}">Lote #{{ $lote->id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Producto:</label>
                            <select name="producto_id" class="form-select" required>
                                <option value="">Seleccionar producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" class="form-control" required min="1">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Solicitar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
