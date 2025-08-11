<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Evidence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'evidences'; // Asegura que use la tabla correcta

    protected $fillable = [
        'category_id',
        'lot_number',
        'product_name',
        'movement_type',
        'evidence_path',
        'comments',
        'user_id',
        'user_name'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'evidence_url',
        'formatted_created_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con la categoría
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * URL completa del archivo de evidencia
     */
    public function getEvidenceUrlAttribute()
    {
        return $this->evidence_path ? Storage::url($this->evidence_path) : null;
    }

    /**
     * Fecha formateada
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Tipo de movimiento formateado
     */
    public function getFormattedMovementTypeAttribute()
    {
        return $this->movement_type == 'entry' ? 'Entrada' : 'Salida';
    }

    /**
     * Eliminar el archivo asociado al eliminar el registro
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($evidence) {
            if ($evidence->evidence_path) {
                Storage::delete($evidence->evidence_path);
            }
        });
    }

    /**
     * Factory para pruebas
     */
    protected static function newFactory()
    {
        return \Modules\SOLICITUD\Database\factories\EvidenceFactory::new();
    }
}