<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateAdmin extends BaseCommand
{
    protected $group       = 'Auth';
    protected $name        = 'auth:create-admin';
    protected $description = 'Tạo tài khoản admin đầu tiên.';

    public function run(array $params)
    {
        $email = CLI::prompt('Email');
        $password = CLI::prompt('Password', null, true);
        
        $users = model('UserModel');
        $user = $users->create([
            'email' => $email,
            'password' => $password,
            'active' => 1
        ]);

        $user->addGroup('admin');

        CLI::write('Tạo tài khoản admin thành công!', 'green');
    }
} 