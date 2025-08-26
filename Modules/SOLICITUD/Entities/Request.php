<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SOLICITUD\Entities\Person;
use Modules\SOLICITUD\Entities\ProductiveUnitWarehouse;
use Modules\SOLICITUD\Entities\Movement;
use Modules\SOLICITUD\Entities\MovementType;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
     'request_date',
    'mba_area',
    'regional_code',
    'regional_name',
    'cost_center_code',
    'cost_center_name',
    'office_manager_name',
    'accountable_type',
    'accountable_number',
    'destinations_requested_goods',
    'group_or_record_code',   
    'person_id',
    'movement_type_id',
    'status',
    'productive_unit_warehouse_id',
    'signature_name',
    'signature_role'
    ];

    /**
     * Relación con persona solicitante.
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Relación con movimientos.
     */
    public function movements()
    {
        return $this->hasMany(Movement::class, 'request_id');
    }

    /**
     * Relación con la bodega/productive unit.
     */
    public function productiveUnitWarehouse()
    {
        return $this->belongsTo(ProductiveUnitWarehouse::class, 'productive_unit_warehouse_id');
    }

    /**
     * Relación con el tipo de movimiento.
     */
    public function movementType()
    {
        return $this->belongsTo(MovementType::class, 'movement_type_id');
    }

     public function items()
    {
        return $this->hasMany(RequestItem::class, 'request_id');
    }
}