<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationEditLog extends Model
{
    protected $fillable = [
        'application_id',
        'edited_by',
        'reason',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
