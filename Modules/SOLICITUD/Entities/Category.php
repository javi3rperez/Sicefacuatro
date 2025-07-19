<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Cambia si tu tabla tiene otro nombre

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Una categoría tiene muchos elementos (productos).
     */
    public function elements()
    {
        return $this->hasMany(Element::class, 'category_id');
    }
}
