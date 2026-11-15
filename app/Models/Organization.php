<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'organization_id';

    protected $fillable = [
        'user_id',
        'organization_name',
        'organization_type',
        'organization_address',
        'verification_status',
        'verification_document'
    ];

    // Links this organization back to its owner in the users table
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}