<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'investment_date',
        'amount',
        'description',
        'income_generated',
        'status',
        'returned_amount',
        'created_by'
    ];

    protected $casts = [
        'investment_date' => 'date',
        'amount' => 'decimal:3',
        'income_generated' => 'decimal:3',
        'returned_amount' => 'decimal:3'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }



    public function getBalanceAttribute()
    {
        return $this->amount - ($this->returned_amount ?? 0);
    }
}
