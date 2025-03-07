<?php

namespace App\Controllers;

use CodeIgniter\Shield\Controllers\LoginController;

class AuthController extends LoginController
{
    public function logout()
    {
        // Thực hiện đăng xuất
        auth()->logout();
        
        // Xóa session
        session()->destroy();
        
        // Chuyển hướng về trang login
        return redirect()->to('/login');
    }
} 