@extends('solicitud::layouts.master')

@section('content')

<title>Detalle Solicitud de Bienes</title>
<style>
  body { font-family: Arial; font-size: 14px; margin: 20px; }
  .form-container {
    max-width: 900px; margin: auto; border: 1px solid #000;
    padding: 20px; overflow-x: auto; box-sizing: border-box;
  }
  table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
  table, th, td { border: 1px solid black; }
  th, td { padding: 4px; text-align: center; }
  input[readonly] { background: #f9f9f9; border: 1px solid #ccc; color: #333; }
  .signature-line { display: flex; align-items: center; margin: 10px 0; flex-wrap: wrap; }
  .signature-line label { font-weight: bold; margin-right: 5px; }
  .signature-line .underline {
    border-bottom: 1px solid #000; padding: 2px 80px;
    margin-right: 20px; display: inline-block; min-width: 150px;
  }
  .actions { text-align: center; margin-top: 30px; }
  .btn { padding: 10px 30px; font-size: 16px; border: none;
    border-radius: 8px; cursor: pointer; font-weight: bold; margin: 5px; }
  .btn-approve { background-color: #2fa933; color: white; }
  .btn-approve:hover { background-color: #1d7a23; }
  .btn-reject { background-color: #d9534f; color: white; }
  .btn-reject:hover { background-color: #a94442; }
</style>

<div class="form-container">
  {{-- ✅ Mensajes flash --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Encabezado --}}
  <div style="background-color: #2c2c2c; color: white; text-align: center; padding: 10px 0;">
    <div style="font-size: 16px;">PROCESO GESTIÓN DE INFRAESTRUCTURA Y LOGÍSTICA</div>
    <div style="font-size: 14px;">FORMATO SOLICITUD DE BIENES PARA USO DE CUSTODIANTES</div>
  </div>

  {{--  Estado de la solicitud --}}
  <div style="margin: 20px 0; text-align:center;">
    @if($solicitud->status == 'approved')
      <span style="padding:8px 20px; background:#2fa933; color:white; border-radius:8px; font-weight:bold;">
        Solicitud Aprobada
      </span>
    @elseif($solicitud->status == 'rejected')
      <span style="padding:8px 20px; background:#d9534f; color:white; border-radius:8px; font-weight:bold;">
         Solicitud Rechazada
      </span>
    @else
      <span style="padding:8px 20px; background:#f0ad4e; color:white; border-radius:8px; font-weight:bold;">
        Solicitud Pendiente
      </span>
    @endif
  </div>

  <br>

  {{-- Datos principales --}}
  <div class="form-section">
    <div class="flex-row">
      <label>Fecha Solicitud:</label>
      <input type="date" value="{{ $solicitud->request_date }}" readonly />
      <label>Área:</label>
      <input type="text" value="{{ $solicitud->mba_area }}" readonly />
    </div>
    <div class="flex-row">
      <label>Código Regional</label>
      <input type="text" value="{{ $solicitud->regional_code }}" readonly />
      <label>Nombre Regional</label>
      <input type="text" value="{{ $solicitud->regional_name }}" readonly />
    </div> 
    <div class="flex-row">
      <label>COD centro de costo</label>
      <input type="text" value="{{ $solicitud->cost_center_code }}" readonly />
      <label>Nombre centro de costo</label>
      <input type="text" value="{{ $solicitud->cost_center_name }}" readonly />
    </div>
    <label>Nombre de jefe de oficina o Coordinador de área</label>
    <input type="text" value="{{ $solicitud->office_manager_name }}" readonly />
    <br><br>
    <label>Tipo de cuentadante</label>
    <input type="text" value="{{ $solicitud->accountable_type }}" readonly />
    <br><br>
    <label>Nombre de cuentadante</label>
    <input type="text" value="{{ $solicitud->accountable_name }}" readonly />
    <br><br>
    <label>Número de cuentadante</label>
    <input type="text" value="{{ $solicitud->accountable_number }}" readonly />
    <br><br>
    <label>Destino de los bienes solicitados</label>
    <input type="text" value="{{ $solicitud->destinations_requested_goods }}" readonly />
    <br><br>
    <label>Código de grupo o ficha de caracterización</label>
    <input type="text" value="{{ $solicitud->group_or_record_code }}" readonly />
  </div>

  <label>Tipo de movimiento</label>
  <input type="text" value="{{ $solicitud->movementType->name ?? 'N/A' }}" readonly />
  <br><br>

  {{-- Tabla de bienes --}}
  <table>
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
      @foreach($solicitud->items as $item)
        <tr>
          <td>{{ $item->sena_code }}</td>
          <td>{{ $item->item_description }}</td>
          <td>{{ $item->measurement_unit }}</td>
          <td>{{ $item->requested_quantity }}</td>
          <td>{{ $item->delivered_quantity }}</td>
          <td>{{ $item->observation ?? '---' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <br><br><br>

  {{-- ✅ Formulario cuando está pendiente --}}
  @if($solicitud->status == 'pending')
  <form action="{{ route('solicitud.admin.request.updateStatus', $solicitud->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Firmas --}}
    <div class="signature-line">
      <label>Nombre:</label>
      <input type="text" name="signature_name"
        value="{{ old('signature_name', $solicitud->signature_name ?? '') }}"
        style="border:none; border-bottom:1px solid #000; width:300px;">
      <label>Cargo:</label>
      <input type="text" name="signature_role"
        value="{{ old('signature_role', $solicitud->signature_role ?? '') }}"
        style="border:none; border-bottom:1px solid #000; width:300px;">
    </div>

    <div class="signature-line">
      <label>Firma:</label>
      <img src="{{ asset('Firma/firmajefe.jpg') }}" alt="Firma Jefe" style="width:260px; height:auto;">
    </div>

    <div class="actions">
      {{-- Aprobar --}}
      <button type="submit" name="status" value="approved" class="btn btn-approve">Aprobar</button>

      {{-- Rechazar --}}
      <button type="button" class="btn btn-reject" onclick="document.getElementById('rejectModal').style.display='block'">
        Rechazar
      </button>
    </div>
  </form>
  @endif

  {{-- ✅ Mostrar firmas cuando esté aprobada o rechazada --}}
  @if($solicitud->status == 'approved' || $solicitud->status == 'rejected')
    <div class="signature-line">
      <label>Nombre:</label>
      <span class="underline">{{ $solicitud->signature_name ?? '---' }}</span>
      <label>Cargo:</label>
      <span class="underline">{{ $solicitud->signature_role ?? '---' }}</span>
    </div>
    <div class="signature-line">
      <label>Firma:</label>
      <img src="{{ asset('Firma/firmajefe.jpg') }}" alt="Firma Jefe" style="width:260px; height:auto;">
    </div>
  @endif

  {{-- Modal rechazo --}}
  <div id="rejectModal" style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; max-width:500px; margin:10% auto; padding:20px; border-radius:8px; position:relative;">
      <h3 style="margin-bottom:15px; color:#d9534f;">Motivo de rechazo</h3>
      <form id="form-reject" action="{{ route('solicitud.admin.request.updateStatus', $solicitud->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="rejected">
        {{-- Incluimos también los datos de firma --}}
        <input type="hidden" name="signature_name" value="{{ old('signature_name', $solicitud->signature_name ?? '') }}">
        <input type="hidden" name="signature_role" value="{{ old('signature_role', $solicitud->signature_role ?? '') }}">
        <textarea name="observation" rows="4" style="width:100%; padding:8px;" placeholder="Escriba el motivo del rechazo..." required></textarea>
        <div style="margin-top:15px; text-align:right;">
          <button type="button" onclick="document.getElementById('rejectModal').style.display='none'" style="padding:8px 20px; border:none; background:#ccc; border-radius:6px; margin-right:10px;">Cancelar</button>
          <button type="submit" class="btn btn-reject">Confirmar Rechazo</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
