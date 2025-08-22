<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function requests()
    {
        return $this->hasMany(Request::class, 'person_id');
    }
}
