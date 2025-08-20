<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovementType extends Model
{
    use HasFactory;

     use HasFactory;

    protected $table = 'movement_types'; // ✅ nombre exacto de tu tabla

    protected $fillable = [
        'name',
        'description'
    ];
}
