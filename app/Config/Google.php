<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Google extends BaseConfig
{
    public string $clientId = '';
    public string $clientSecret = '';
    public string $redirectUri = '';
    
    public function __construct()
    {
        parent::__construct();
        
        // Cấu hình trực tiếp
        
        $this->redirectUri = 'https://muster.vn/auth/google/callback';
    }
}   