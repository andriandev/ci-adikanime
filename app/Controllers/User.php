<?php

namespace App\Controllers;

use \App\Models\User_Model;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User_Model();
    }

    public function profile()
    {
        // Mengambil data user dari DB berdasarkan session id
        $user = $this->userModel->getUser(session()->get('id'));
        if ($user) {
            $data = [
                'title' => 'Profile ' . $user['username'],
                'user' => $user,
                'validation' => \Config\Services::validation()
            ];

            return view('user/profile', $data);
        }

        return view('pages/error');
    }

    public function profile_update()
    {
        $id = htmlspecialchars($this->request->getVar('id'));
        $username = strtolower(htmlspecialchars($this->request->getVar('username')));;
        $password = $this->request->getVar('password');
        $email = htmlspecialchars($this->request->getVar('email'));

        // Mengambil data dari DB brdasarkan id
        $user = $this->userModel->getUser($id);

        // Cek user yang akan mengupdate penulisnya atau bukan
        if ($user['id'] != session()->get('id')) {
            // Session setFlashdata
            $pesan = '<div class="alert alert-danger text-center" role="alert">
                            Akses ditolak.
                            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/profile');
        }

        if ($user['username'] == $username) {
            $rulesUsername = 'required';
        } else {
            $rulesUsername = 'required|is_unique[tb_users.username]';
        }

        if (empty($password)) {
            $password = $user['password'];
            $rulesPassword = 'string';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $rulesPassword = 'required';
        }

        if (!$this->validate([
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id harus di isi'
                ]
            ],
            'username' => [
                'rules' => $rulesUsername,
                'errors' => [
                    'required' => 'Username harus di isi',
                    'is_unique' => 'Username sudah ada di database'
                ]
            ],
            'password' => [
                'rules' => $rulesPassword,
                'errors' => [
                    'required' => 'Password harus di isi'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email harus di isi'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $this->userModel->save([
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'email' => $email
        ]);

        // Set session
        $ses = [
            'username' => $user['username'],
            'email' => $user['email']
        ];
        session()->set($ses);

        // Session setFlashdata
        $pesan = '<div class="alert alert-success text-center" role="alert">
            Data User Berhasil Di Edit.
            </div>';
        session()->setFlashdata('pesan', $pesan);

        return redirect()->to('/profile');
    }
}
