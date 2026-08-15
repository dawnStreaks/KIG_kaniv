<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_date',
        'particulars',
        'amount',
        'bill_path',
        'type',
        'application_id',
        'entered_by',
        'beneficiary',
        'paid_by_area_id',
        'paid_by_mekhala_id',
    ];

    protected $casts = [
        'amount' => 'decimal:3',
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

    public function paidByArea()
    {
        return $this->belongsTo(Area::class, 'paid_by_area_id');
    }

    public function paidByMekhala()
    {
        return $this->belongsTo(Mekhala::class, 'paid_by_mekhala_id');
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