<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\SOLICITUD\Database\factories\PersonFactory::new();
    }
}
