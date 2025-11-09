<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'unit_id',
        'amount',
        'collection_date',
        'term',
        'type',
        'year',
        'entered_by',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'collection_date' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function getYearAttribute()
    {
        return $this->collection_date ? $this->collection_date->format('Y') : null;
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('collection_date', [$startDate, $endDate]);
    }
}