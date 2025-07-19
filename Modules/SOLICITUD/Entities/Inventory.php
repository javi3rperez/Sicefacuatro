<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SOLICITUD\Entities\Element;
use Modules\SOLICITUD\Entities\ProductiveUnitWarehouse;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'element_id',
        'productive_unit_warehouse_id',
        'stock',
        'image',
    ];

    protected static function newFactory()
    {
        return \Modules\SOLICITUD\Database\factories\InventoryFactory::new();
    }

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function productiveUnitWarehouse()
    {
        return $this->belongsTo(ProductiveUnitWarehouse::class, 'productive_unit_warehouse_id');
    }
}
