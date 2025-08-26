<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\Warehouse;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';

    protected $fillable = [
        'type',
        'quantity',
        'warehouse_id',
        'element_id',
        'registration_date',
        'return_date',
        'movement_type_id',
        'voucher_number',
        'observation',
        'state',
        'request_id',
    ];

    // Relación con almacén
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Relación con elemento
    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    // Relación con solicitud
    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    // Relación con tipo de movimiento
    public function movementType()
    {
        return $this->belongsTo(MovementType::class, 'movement_type_id');
    }

    // Accesor para categoría (desde element)
    public function getCategoryAttribute()
    {
        return $this->element?->category;
    }

    // Scope para entradas
    public function scopeEntries($query)
    {
        return $query->where('type', 'entry');
    }

    // Scope para salidas
    public function scopeExits($query)
    {
        return $query->where('type', 'exit');
    }
}
