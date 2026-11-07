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
        'verification_status',
    ];
}
