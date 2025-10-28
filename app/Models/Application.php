<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'front_page_photo',
        'name',
        'passport_no',
        'civil_id',
        'mobile_number',
        'category',
        'status',
        'approved_amount',
        'approved_date',
        'submitted_by',
        'reviewed_by',
    ];

    protected $casts = [
        'approved_amount' => 'decimal:2',
        'approved_date' => 'date',
    ];

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}