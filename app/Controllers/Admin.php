<?php

namespace App\Controllers;

use \App\Models\Admin_Model;

class Admin extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin_Model();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin'
        ];
        return view('admin/index', $data);
    }

    public function user($page = 1)
    {
        $limit = 10;
        $offset = $this->adminModel->getOffset($page, $limit);
        $totalUser = $this->adminModel->getCountAllUser();
        $totalPage = $this->adminModel->getPageCount($totalUser, $limit);
        $data = [
            'title' => 'Manage Users',
            'offset' => $offset,
            'paginate' => printPagination('/admin/user/', $page, $totalPage),
            'users' => $this->adminModel->getAllUser($limit, $offset),
            'totalUser' => $totalUser,
            'page' => $page,
            'totalPage' => $totalPage
        ];
        return view('admin/user/index', $data);
    }

    public function user_create()
    {
        $data = [
            'title' => 'Create User',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/user/create', $data);
    }

    public function user_save()
    {
        if (isset($_POST)) {
            if (!$this->validate([
                'username' => [
                    'rules' => 'required|is_unique[tb_users.username]',
                    'errors' => [
                        'required' => 'Username harus di isi',
                        'is_unique' => 'Username sudah ada di database'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus di isi'
                    ]
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email harus di isi'
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Role harus di isi'
                    ]
                ],
                'active' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Active harus di isi'
                    ]
                ]
            ])) {
                return redirect()->back()->withInput();
            }

            $username = strtolower(htmlspecialchars($this->request->getVar('username')));
            $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
            $email = htmlspecialchars($this->request->getVar('email'));
            $role = htmlspecialchars($this->request->getVar('role'));
            $active = htmlspecialchars($this->request->getVar('active'));

            $this->adminModel->save([
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'role' => $role,
                'active' => $active
            ]);

            // Session setFlashdata
            $pesan = '<div class="alert alert-success text-center" role="alert">
            User Berhasil Ditambahkan.
            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/admin/user');
        }
    }

    public function user_edit($id = null)
    {
        $user = $this->adminModel->getUserById($id);
        if (!$user) {
            return view('pages/error');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/user/edit', $data);
    }

    public function user_update()
    {
        if (isset($_POST)) {
            $id = htmlspecialchars($this->request->getVar('id'));
            $username = strtolower(htmlspecialchars($this->request->getVar('username')));;
            $password = $this->request->getVar('password');
            $email = htmlspecialchars($this->request->getVar('email'));
            $role = htmlspecialchars($this->request->getVar('role'));
            $active = htmlspecialchars($this->request->getVar('active'));

            // Mengambil data dari DB brdasarkan id
            $user = $this->adminModel->getUserById($id);

            if ($user['username'] == $username) {
                $rulesUsername = 'required';
            } else {
                $rulesUsername = 'required|is_unique[tb_users.username]';
            }

            if ($user['password'] == $password) {
                $password = $password;
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }

            if (!$this->validate([
                'username' => [
                    'rules' => $rulesUsername,
                    'errors' => [
                        'required' => 'Username harus di isi',
                        'is_unique' => 'Username sudah ada di database'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus di isi'
                    ]
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email harus di isi'
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Role harus di isi'
                    ]
                ],
                'active' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Active harus di isi'
                    ]
                ]
            ])) {
                return redirect()->back()->withInput();
            }

            $this->adminModel->save([
                'id' => $id,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'role' => $role,
                'active' => $active
            ]);

            // Session setFlashdata
            $pesan = '<div class="alert alert-warning text-center" role="alert">
            User Berhasil Di Edit.
            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/admin/user/edit/' . $id);
        }
    }

    public function user_delete($id = null)
    {
        $this->adminModel->where('id', $id)->delete();

        // Session setFlashdata
        $pesan = '<div class="alert alert-danger text-center" role="alert">
            User Berhasil Di Hapus.
            </div>';
        session()->setFlashdata('pesan', $pesan);

        return redirect()->to('/admin/user');
    }

    public function setting()
    {
        $data = [
            'title' => 'Admin Setting',
            'cache' => \Config\Services::cache()
        ];

        return view('admin/setting/index', $data);
    }

    public function cache()
    {
        $cache = \Config\Services::cache();
        $key = $this->request->getPost('key');

        if ($key == 'allDataCache') {
            $result = $cache->clean();

            if ($result) {
                // Session setFlashdata
                $pesan = '<div class="alert alert-success text-center" role="alert">
                Semua cache berhasil dihapus.
                </div>';
                session()->setFlashdata('pesan', $pesan);

                return redirect()->to('/admin/setting');
            }
        } else if ($key == 'oneDataCache') {
            $keyCache = $this->request->getPost('keyCache');

            if (!empty($keyCache)) {
                $result = $cache->delete($keyCache);

                if ($result) {
                    // Session setFlashdata
                    $pesan = '<div class="alert alert-success text-center" role="alert">
                    Cache ' . $keyCache . ' berhasil dihapus.
                    </div>';
                    session()->setFlashdata('pesan', $pesan);

                    return redirect()->to('/admin/setting');
                }
            }
        } else if ($key == 'prefixDataCache') {
            $keyCache = $this->request->getPost('keyCache');
            $setup = $this->request->getPost('setup');

            if (!empty($keyCache)) {
                if ($setup == 'prefix') {
                    $keyCache = $keyCache . '*';
                } else if ($setup == 'suffix') {
                    $keyCache = '*' . $keyCache;
                }

                $result = $cache->deleteMatching($keyCache);

                if ($result) {
                    // Session setFlashdata
                    $pesan = '<div class="alert alert-success text-center" role="alert">
                    Cache dengan ' . $setup . ' ' . $keyCache . ' dengan jumlah ' . $result . ' berhasil dihapus.
                    </div>';
                    session()->setFlashdata('pesan', $pesan);

                    return redirect()->to('/admin/setting');
                }
            }
        }

        // Session setFlashdata
        $pesan = '<div class="alert alert-danger text-center" role="alert">
        Terjadi Kesalahan.
        </div>';
        session()->setFlashdata('pesan', $pesan);

        return redirect()->to('/admin/setting');
    }
}
