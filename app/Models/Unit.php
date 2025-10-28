<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'area_id', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTotalCollectionAttribute()
    {
        return $this->collections()->sum('amount');
    }
}