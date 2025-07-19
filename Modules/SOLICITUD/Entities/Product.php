<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;

    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'name',
        'program',
        'batch',
        'product', // Nombre del producto (quizá quieras renombrar este campo)
        'quantity',
        'date'
    ];

    /**
     * Campos de fecha (opcional, pero recomendado)
     */
    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    /**
     * Relaciones (si necesitas agregarlas después)
     * Ejemplo:
     * public function user() {
     *     return $this->belongsTo(User::class);
     * }
     */

    /**
     * Factory asociado (para pruebas)
     */
    protected static function newFactory()
    {
        return \Modules\SOLICITUD\Database\factories\ProductFactory::new();
    }
}