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

        public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
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
}
