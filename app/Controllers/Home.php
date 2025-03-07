<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = ['title' => 'Home'];
        $data['body'] = get_body('public/home', $data); // Thêm hàm get_body nếu cần
        return view('layout/public/main', $data);
    }
}
