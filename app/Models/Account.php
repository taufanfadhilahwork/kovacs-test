<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_id';

    protected $fillable = [
        'account_type',
        'account_number',
        'account_paid',
        'account_title',
        'account_notes',
        'account_amount',
        'account_outstanding',
        'applicant_id'
    ];
}
