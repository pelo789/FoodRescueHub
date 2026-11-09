<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'organization_name',
        'role',
        'status',
        'verification_status',
        'verification_document',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdministrator(): bool
    {
        // "admin" is retained for compatibility with existing accounts.
        return in_array($this->role, ['administrator', 'admin'], true);
    }

    public function isOrganizationVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function canParticipateInRedistribution(): bool
    {
        return $this->status === 'active'
            && $this->isOrganizationVerified()
            && in_array(
                $this->role,
                ['food_provider', 'recipient_organization'],
                true
            );
    }
}