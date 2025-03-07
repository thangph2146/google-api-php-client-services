<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Bạn cần đăng nhập để truy cập trang quản trị');
        }

        // Kiểm tra xem người dùng có quyền admin không
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Bạn không có quyền truy cập trang quản trị');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 