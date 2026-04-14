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
        'application_type_id',
        'unit_id',
        'area_id',
        'status',
        'approved_amount',
        'approved_date',
        'submitted_by',
        'reviewed_by',
    ];

    protected $casts = [
        'approved_amount' => 'decimal:3',
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

    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePayable($query)
    {
        return $query->where('status', 'payable');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}