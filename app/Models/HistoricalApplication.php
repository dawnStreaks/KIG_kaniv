<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalApplication extends Model
{
    protected $fillable = [
        'name',
        'passport_no',
        'civil_id',
        'mobile_number',
        'category',
        'application_type',
        'area_name',
        'unit_name',
        'status',
        'approved_amount',
        'applied_date',
        'notes',
    ];

    protected $casts = [
        'approved_amount' => 'decimal:3',
        'applied_date' => 'date',
    ];
}
