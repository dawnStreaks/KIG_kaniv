<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    protected $table = 'opening_balance';
    
    protected $fillable = ['amount', 'year', 'mekhala_id'];
    
    public function mekhala()
    {
        return $this->belongsTo(Mekhala::class);
    }
}
