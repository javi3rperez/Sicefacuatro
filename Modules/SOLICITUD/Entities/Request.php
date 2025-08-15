<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\ProductiveUnitWarehouse;
use Modules\SICA\Entities\MovementType;

class Request extends Model
{
    use HasFactory;

     rotected $table = 'requests'; 

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
    'sena_code',
    'item_description',
    'requested_quantity',
    'delivered_quantity',
    'observation',

    ];
    
    
}
