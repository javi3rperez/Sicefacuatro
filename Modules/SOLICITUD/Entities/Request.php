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

     protected $table = 'request'; // Asegura que use la tabla correcta

    protected $fillable = [
        'name',
        'program',
        'batch',
        'product',
        'quantity',
        'date'
    ];
    
    protected static function newFactory()
    {
        return \Modules\SOLICITUD\Database\factories\RequestFactory::new();
    }
    public function person()
    {
        return $this->belongsTo(Person::class, 'people_id'); // Asegúrate que 'person_id' sea el nombre correcto de la FK
    }

     public function productiveUnitWarehouse()
    {
        return $this->belongsTo(ProductiveUnitWarehouse::class, 'productive_unit_warehouses_id'); // Asegúrate que 'person_id' sea el nombre correcto de la FK
    }

    public function movementtype()
    {
        return $this->belongsTo(MovementType::class, 'movement_types_id'); // Asegúrate que 'person_id' sea el nombre correcto de la FK
    }

    protected $dates = [
    'request_date',
    'required_date',
    'created_at',
    'updated_at'
];
}
