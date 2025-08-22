@extends('solicitud::layouts.masterinstructor') 

@section('content')

  <title>Formato Solicitud de Bienes</title>
  <style>
    body {
      font-family: Arial;
      font-size: 14px;
      margin: 20px;
    }
    h2, h4 { text-align: center; }
    .form-container {
      max-width: 900px;
      margin: auto;
      border: 1px solid #000;
      padding: 20px;
      overflow-x: auto;
      box-sizing: border-box;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      table-layout: fixed;
    }
    table, th, td { border: 1px solid black; }
    th, td { padding: 4px; text-align: center; }
    table input[type="text"] {
      width: 100%;
      box-sizing: border-box;
      padding: 2px;
      border: none;
      outline: none;
      text-align: center;
      background: transparent;
      font-family: inherit;
      font-size: inherit;
    }
    .flex-row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    .form-section { margin-bottom: 20px; }
    label {
      font-weight: bold;
      margin-right: 10px;
    }
    input[type="text"], input[type="date"], select {
      width: 250px;
      padding: 5px;
      margin-bottom: 5px;
      box-sizing: border-box;
      border: 1px solid #ccc;
    }
    .signature-complete {
      margin-top: 40px;
      font-size: 14px;
    }
    .signature-line {
      display: flex;
      align-items: center;
      margin: 10px 0;
      flex-wrap: wrap;
    }
    .signature-line label {
      font-weight: bold;
      margin-right: 5px;
    }
    .signature-line .underline {
      border-bottom: 1px solid #000;
      padding: 2px 80px;
      margin-right: 20px;
      display: inline-block;
      min-width: 150px;
    }
    button {
      padding: 10px 30px;
      background-color: #2fa933ff;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px; 
    }
    button:hover { background-color: #45a049; }
    @media screen and (max-width: 768px) {
      .flex-row { flex-direction: column; }
      input[type="text"], input[type="date"], select { width: 100%; }
      table { display: block; overflow-x: auto; }
    }
    .btn-small {
      padding: 5px 10px;
      font-size: 12px;
      border-radius: 4px;
      margin: 2px;
    }
    .btn-danger { background-color: red; }
    .btn-secondary { background-color: gray; }
  </style>

  
  <form action="{{ route('solicitud.instructor.store') }}" method="POST">
    @csrf
    <div class="form-container">
      
      <div style="background-color: #2c2c2c; color: white; text-align: center; padding: 10px 0;">
        <div style="font-size: 16px;">PROCESO GESTIÓN DE INFRAESTRUCTURA Y LOGÍSTICA</div>
        <div style="font-size: 14px;">FORMATO SOLICITUD DE BIENES PARA USO DE CUSTODIANTES</div>
      </div>

      <br><br>

      <div class="form-section">
        <div class="flex-row">
          <label>Fecha Solicitud:</label>
          <input type="date" name="request_date" required />
          <label>Área:</label>
          <input type="text" name="mba_area" required />
        </div>
        <div class="flex-row">
          <label>Código Regional</label>
          <input type="text" name="regional_code" required />
          <label>Nombre Regional</label>
          <input type="text" name="regional_name" required />
        </div> 
        <div class="flex-row">
          <label>COD centro de costo</label>
          <input type="text" name="cost_center_code" required />
          <label>Nombre centro de costo</label>
          <input type="text" name="cost_center_name" required />
        </div>
        
        <label>Nombre de jefe de oficina o Coordinador de área</label>
        <input type="text" name="office_manager_name" required />
        
        <br><br>
        <label>Tipo de cuentadante</label>
        <select name="accountable_type" required>
          <option value="">Seleccione...</option>
          <option value="Unipersonal">Unipersonal</option>
          <option value="Múltiple">Múltiple</option>
        </select>
        
        <br><br>
        <label>Nombre de cuentadante</label>
        <input type="text" name="accountable_name" required />
        
        <br><br>
        <label>Número de cuentadante</label>
        <input type="text" name="accountable_number" required />
        
        <br><br>
        <label>Destino de los bienes solicitados</label>
        <input type="text" name="destinations_requested_goods" required />
        
        <br><br>
        <label>Código de grupo o ficha de caracterización</label>
        <input type="text" name="group_or_record_code" required />
      </div>

      <label>Tipo de movimiento</label>
      <select name="movement_type_id" required>
        <option value="">Seleccione tipo de movimiento...</option>
        @foreach($movement_types as $type)
          <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
      </select>
      <br><br>

      <table id="tabla-bienes">
        <thead>
          <tr>
            <th style="width: 15%;">Código SENA</th>
            <th style="width: 25%;">Descripción del Bien</th>
            <th style="width: 10%;">Unidad de medida</th>
            <th style="width: 10%;">Cantidad solicitada</th>
            <th style="width: 20%;">Cantidad entregada</th>
            <th style="width: 20%;">Observaciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" name="sena_code[]" required /></td>
            <td><input type="text" name="item_description[]" required /></td>
            <td><input type="text" name="measurement_unit[]" required /></td>
            <td><input type="text" name="requested_quantity[]" required /></td>
            <td><input type="text" name="delivered_quantity[]"/></td>
            <td><input type="text" name="observation[]" /></td>
            
          </tr>
        </tbody>
      </table>


      <br><br><br>

      <div class="signature-complete">
        <div class="signature-line">
          <label>Nombre:</label>
          <span class="underline"></span>
          <label>Cargo:</label>
          <span class="underline"></span>
        </div>
        <div class="signature-line">
          <label>Firma:</label>
          <span class="underline"></span>
        </div>
      </div>
      <br>
      <div style="text-align: center; margin-top: 20px;">
        <button type="submit">Solicitar</button>
      </div>
    </div>
  </form>

  <script>
    function agregarFila() {
      let tabla = document.getElementById("tabla-bienes").getElementsByTagName('tbody')[0];
      let nuevaFila = tabla.rows[0].cloneNode(true);

      nuevaFila.querySelectorAll("input").forEach(input => input.value = "");
      tabla.appendChild(nuevaFila);
    }

    function eliminarFila(boton) {
      let fila = boton.closest("tr");
      let tabla = fila.parentNode;
      if (tabla.rows.length > 1) {
        fila.remove();
      } else {
        alert("Debe existir al menos una fila.");
      }
    }
  </script>

@endsection