<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // --- ADD THESE THREE LINES ---
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    // -----------------------------

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ADD THIS RELATIONSHIP METHOD HERE:
    public function organization()
    {
        return $this->hasOne(Organization::class, 'user_id', 'user_id');
    }
}