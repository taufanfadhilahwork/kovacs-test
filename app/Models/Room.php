<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_id';
    public $timestamps = false;

    protected $fillable = [
        'room_number',
        'room_block',
        'room_price',
        'room_breakage_deposit',
        'room_type',
        'room_status',
        'room_application_id',
        'room_applicant_id',
        'room_hold_description',
    ];
}
