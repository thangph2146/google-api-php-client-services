<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google_Client;
use Google_Service_Oauth2;

class GoogleAuthController extends Controller
{
    private $googleClient;
    
    public function __construct()
    {
        $config = config('Google');
        
        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId($config->clientId);
        $this->googleClient->setClientSecret($config->clientSecret);
        $this->googleClient->setRedirectUri($config->redirectUri);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }
    
    public function login()
    {
        return redirect()->to($this->googleClient->createAuthUrl());
    }
    
    public function callback()
    {
        try {
            // Lấy token từ code
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            $this->googleClient->setAccessToken($token);
            
            // Lấy thông tin user
            $service = new Google_Service_Oauth2($this->googleClient);
            $userInfo = $service->userinfo->get();
            
            // Kiểm tra email đã tồn tại chưa
            $userModel = model('UserModel');
            $user = $userModel->where('email', $userInfo->email)->first();
            
            if (!$user) {
                // Tạo user mới
                $user = $userModel->create([
                    'username' => explode('@', $userInfo->email)[0],
                    'email' => $userInfo->email,
                    'password' => bin2hex(random_bytes(16)), // Mật khẩu ngẫu nhiên
                    'active' => 1
                ]);
                
                // Thêm vào nhóm user
                $user->addGroup('user');
            }
            
            // Đăng nhập user
            auth()->login($user);
            
            return redirect()->to('/admin/dashboard')
                           ->with('message', 'Đăng nhập thành công với Google!');
                           
        } catch (\Exception $e) {
            return redirect()->to('/login')
                           ->with('error', 'Đăng nhập Google thất bại: ' . $e->getMessage());
        }
    }
} 