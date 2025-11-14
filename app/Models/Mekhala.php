<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekhala extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}