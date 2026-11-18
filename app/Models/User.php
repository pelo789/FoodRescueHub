<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    // ORGANIZATION RELATIONSHIP
    public function organization()
    {
        return $this->hasOne(Organization::class, 'user_id', 'user_id');
    }

    // CHECK IF USER IS AN ADMINISTRATOR
    public function isAdministrator(): bool
    {
        return in_array($this->role, ['administrator', 'admin'], true);
    }

    // CHECK IF ORGANIZATION IS VERIFIED
    public function isOrganizationVerified(): bool
    {
        return strtolower(trim($this->verification_status ?? '')) === 'verified';
    }

    // CHECK IF USER CAN PARTICIPATE IN FOOD REDISTRIBUTION
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
