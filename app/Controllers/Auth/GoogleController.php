<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Google_Client;
use Google_Service_Oauth2;
use CodeIgniter\Shield\Auth\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Models\UserIdentityModel;
use Config\Google as GoogleConfig;

class GoogleController extends BaseController
{
    protected $googleClient;
    protected $auth;
    protected $config;

    public function __construct()
    {
        $this->config = config('Google');
        $this->auth = service('auth');
        
        // Khởi tạo Google Client
        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId($this->config->clientId);
        $this->googleClient->setClientSecret($this->config->clientSecret);
        $this->googleClient->setRedirectUri($this->config->redirectUri);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function redirect(): RedirectResponse
    {
        // Force account selection by adding prompt parameter
        $this->googleClient->setPrompt('select_account');
        
        // Tạo URL đăng nhập Google
        $authUrl = $this->googleClient->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        try {
            if (!isset($_GET['code'])) {
                return redirect()->to('/login')
                    ->with('error', 'Không nhận được mã xác thực từ Google.');
            }

            // Lấy token từ code
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['error'])) {
                return redirect()->to('/login')
                    ->with('error', 'Lỗi xác thực: ' . $token['error_description']);
            }
            
            $this->googleClient->setAccessToken($token);

            // Lấy thông tin user từ Google
            $service = new Google_Service_Oauth2($this->googleClient);
            $googleUser = $service->userinfo->get();

            // Trong Shield, email lưu trong bảng auth_identities, không phải users
            $identityModel = new UserIdentityModel();
            $identity = $identityModel->where('type', 'email_password')
                                      ->where('secret', $googleUser->email)
                                      ->first();

            $users = new UserModel();
            if ($identity) {
                // Nếu đã tồn tại user với email này
                $user = $users->findById($identity->user_id);
            } else {
                // Tạo user mới nếu chưa tồn tại
                $user = new User([
                    'username' => $this->generateUsername($googleUser->email),
                    'active' => 1,
                ]);

                $userId = $users->insert($user);
                $user = $users->findById($userId);
                
                // Tạo identity email_password cho user mới
                $identityModel->insert([
                    'user_id' => $userId,
                    'type' => 'email_password',
                    'name' => null,
                    'secret' => $googleUser->email, // Email được lưu ở đây
                    'secret2' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT), // Mật khẩu ngẫu nhiên
                    'expires' => null,
                ]);
                
                // Thêm vào nhóm user
                $user->addGroup('user');
            }
            
            // Lưu thông tin Google ID vào bảng identities của Shield
            $googleIdentity = $identityModel->where('user_id', $user->id)
                                           ->where('type', 'google')
                                           ->first();
                
            if (!$googleIdentity) {
                $identityModel->insert([
                    'user_id' => $user->id,
                    'type' => 'google',
                    'name' => $googleUser->name,
                    'secret' => $googleUser->id, // Google ID
                    'secret2' => null,
                    'expires' => null,
                    'extra' => json_encode([
                        'picture' => $googleUser->picture,
                        'locale' => $googleUser->locale ?? null,
                    ]),
                ]);
            } else {
                // Cập nhật thông tin nếu đã tồn tại
                $identityModel->update($googleIdentity->id, [
                    'name' => $googleUser->name,
                    'extra' => json_encode([
                        'picture' => $googleUser->picture,
                        'locale' => $googleUser->locale ?? null,
                    ]),
                ]);
            }

            // Đăng nhập user sử dụng Shield
            $this->auth->login($user);

            // Chuyển hướng dựa trên nhóm người dùng
            if ($user->inGroup('admin')) {
                return redirect()->to('/admin/dashboard')
                               ->with('message', 'Đăng nhập thành công với Google!');
            } elseif ($user->inGroup('student')) {
                return redirect()->to('/student/dashboard')
                               ->with('message', 'Đăng nhập thành công với Google!');
            } else {
                // Mặc định nếu không thuộc nhóm nào cụ thể
                return redirect()->to('/dashboard')
                               ->with('message', 'Đăng nhập thành công với Google!');
            }

        } catch (\Exception $e) {
            return redirect()->to('/login')
                           ->with('error', 'Đăng nhập Google thất bại: ' . $e->getMessage());
        }
    }

    protected function generateUsername(string $email): string
    {
        // Tạo username từ email
        $username = explode('@', $email)[0];
        
        // Kiểm tra username đã tồn tại chưa
        $users = new UserModel();
        $count = 0;
        $newUsername = $username;
        
        while ($users->where('username', $newUsername)->first()) {
            $count++;
            $newUsername = $username . $count;
        }
        
        return $newUsername;
    }
}