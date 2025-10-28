<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_date',
        'particulars',
        'amount',
        'type',
        'application_id',
        'entered_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function scopeApplicationExpenses($query)
    {
        return $query->where('type', 'application');
    }

    public function scopeMekhalaExpenses($query)
    {
        return $query->where('type', 'mekhala');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }
}