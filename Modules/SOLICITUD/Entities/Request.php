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

    protected $table = 'requests'; 

    protected $fillable = [
    'person_id',
    'request_date' => 'date',
    'status' => 'pending', 
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
    'movement_type_id', 
    'sena_code',
    'item_description',
    'requested_quantity',
    'delivered_quantity',
    'observation',

    ];
    
    
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function movements()
    {
        return $this->hasMany(Movement::class, 'request_id');
    }
}
