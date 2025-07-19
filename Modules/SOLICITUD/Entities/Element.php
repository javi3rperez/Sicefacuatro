<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SOLICITUD\Entities\Category; 

class Element extends Model
{
    use HasFactory;

    protected $table = 'elements'; 

    protected $fillable = [
        'name',
        'category_id',
    ];
    
    protected static function newFactory()
    {
        return \Modules\SOLICITUD\Database\factories\ElementFactory::new();
    }

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
