<?php

namespace Modules\SOLICITUD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';

    protected $fillable = [
        'registration_date',
        'return_date',
        'movement_type_id',
        'voucher_number',
        'observation',
        'state',
        'request_id',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function movementType()
    {
        return $this->belongsTo(MovementType::class, 'movement_type_id');
    }
}
