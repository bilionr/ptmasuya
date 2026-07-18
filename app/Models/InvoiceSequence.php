<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSequence extends Model
{
    protected $fillable = [
        'period_key',
        'last_number',
    ];

    protected $casts = [
        'last_number' => 'integer',
    ];
}
