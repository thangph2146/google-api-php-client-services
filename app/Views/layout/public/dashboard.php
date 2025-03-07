<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Dashboard'];
        $data['body'] = get_body('admin/dashboard', $data);
        return view('layout/admin/main', $data);
    }
}