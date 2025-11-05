<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'role',
        'area_id',
        'mekhala_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function mekhala()
    {
        return $this->belongsTo(Mekhala::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'submitted_by');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'entered_by');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'entered_by');
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin' || $this->user_type === 'center';
    }

    public function isAreaUser()
    {
        return $this->user_type === 'area';
    }

    public function isMekhalaUser()
    {
        return $this->user_type === 'mekhala';
    }

    public function isChairman()
    {
        return $this->user_type === 'mekhala' && $this->role === 'chairman';
    }

    public function isTreasurer()
    {
        return $this->user_type === 'mekhala' && $this->role === 'treasurer';
    }

    public function canApproveApplications()
    {
        return $this->isAdmin() || $this->isChairman();
    }

    public function canAddExpenses()
    {
        return $this->isAdmin() || $this->isTreasurer();
    }
}
