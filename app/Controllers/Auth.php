<?php

namespace App\Controllers;

use \App\Models\Auth_Model;

class Auth extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new Auth_Model();
    }

    public function register()
    {
        // if (!$_GET['auth']) {
        //     if (!$_GET['auth'] == 'wedos') {
        //         return view('pages/error');
        //     }
        // }
        $data = [
            'title' => 'Register'
        ];
        return view('auth/register', $data);
    }

    public function register_cek()
    {
        if (isset($_POST)) {
            $username = htmlspecialchars($this->request->getVar('username'));
            $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
            $email = htmlspecialchars($this->request->getVar('email'));

            $this->authModel->save([
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'role' => 'member',
                'active' => 0
            ]);

            // Session setFlashdata
            $pesan = '<div class="alert alert-success text-center" role="alert">
            Register Berhasil
            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/login');
        }
    }

    public function login()
    {
        // if (!$_GET['auth']) {
        //     if (!$_GET['auth'] == 'wedos') {
        //         return view('pages/error');
        //     }
        // }
        $data = [
            'title' => 'Login'
        ];
        return view('auth/login', $data);
    }

    public function login_cek()
    {
        if (isset($_POST)) {
            $username = htmlspecialchars($this->request->getVar('username'));
            $password = $this->request->getVar('password');

            $user = $this->authModel->getUser($username);
            if (!$user) {
                // Jika user tidak ditemukan
                // Session setFlashdata
                $pesan = '<div class="alert alert-danger text-center" role="alert">
                Username atau password salah.
                </div>';
                session()->setFlashdata('pesan', $pesan);

                return redirect()->to('/login');
            } else {
                // Jika user ada cek active == 1
                if ($user['active'] != '1') {
                    // Session setFlashdata
                    $pesan = '<div class="alert alert-danger text-center" role="alert">
                    User belum di aktifkan.
                    </div>';
                    session()->setFlashdata('pesan', $pesan);

                    return redirect()->to('/login');
                }

                // Jika user ada dan cek password
                if (password_verify($password, $user['password'])) {
                    // Set session
                    $ses = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'active' => $user['active']
                    ];
                    session()->set($ses);

                    // Session setFlashdata
                    $pesan = '<div class="alert alert-success text-center" role="alert">
                    Login Berhasil.
                    </div>';
                    session()->setFlashdata('pesan', $pesan);

                    return redirect()->to('/post/all');
                } else {
                    // Jika password salah
                    // Session setFlashdata
                    $pesan = '<div class="alert alert-danger text-center" role="alert">
                    Password salah.
                    </div>';
                    session()->setFlashdata('pesan', $pesan);

                    return redirect()->to('/login');
                }
            }
        }
    }

    public function logout()
    {
        // Remove session
        $ses = [
            'id' => '',
            'username' => '',
            'role' => '',
            'email' => '',
            'active' => ''
        ];
        session()->set($ses);
        $ses = ['id', 'username', 'role', 'email', 'active'];
        session()->remove($ses);

        // Session setflashdata
        $pesan = '<div class="alert alert-info text-center" role="alert">
        Anda berhasil logout.
        </div>';
        session()->setFlashdata('pesan', $pesan);

        return redirect()->to('/login');
    }
}
