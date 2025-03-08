<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $allowedFields = [
        'username',
        'status',
        'status_message',
        'active',
        'last_active',
        'email',
        'password',
        'password_hash',
        'google_id',
        'avatar',
        'full_name',
    ];
} 