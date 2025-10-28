<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'description', 'mekhala_id', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function mekhala()
    {
        return $this->belongsTo(Mekhala::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}