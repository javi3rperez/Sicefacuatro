<?php
<<<<<<< HEAD
namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\Warehouse;

class Movement extends Model
{
    protected $fillable = [
        'type',
        'quantity',
        'warehouse_id',
        'element_id'
    ];

    // Relación con ubicación (almacén)
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Relación con producto (element)
    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    // Accesor para categoría (a través de element)
    public function getCategoryAttribute()
    {
        return $this->element->category;
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
=======

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';

    protected $fillable = [
        'registration_date',
        'return_date',
        'movement_type_id',
        'voucher_number',
        'observation',
        'state',
        'request_id',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function movementType()
    {
        return $this->belongsTo(MovementType::class, 'movement_type_id');
    }
}
>>>>>>> 749a542d12a928fdf8f651fc7497f895bef4991b
