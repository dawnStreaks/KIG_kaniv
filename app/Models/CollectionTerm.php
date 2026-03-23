<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionTerm extends Model
{
    protected $fillable = ['name', 'is_active', 'collection_type_id'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function collectionType()
    {
        return $this->belongsTo(CollectionType::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}