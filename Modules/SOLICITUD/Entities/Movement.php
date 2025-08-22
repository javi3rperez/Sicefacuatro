<?php
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