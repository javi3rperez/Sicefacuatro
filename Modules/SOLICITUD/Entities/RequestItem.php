<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestItem extends Model
{
     use HasFactory;

    protected $fillable = [
        'request_id',
        'group_or_record_code',
        'sena_code',
        'item_description',
        'measurement_unit',
        'requested_quantity',
        'delivered_quantity',
        'observation'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}