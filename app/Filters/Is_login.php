<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Is_login implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $data = [
            'id' => session()->get('id'),
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'active' => session()->get('active')
        ];
        if (!$data['id'] || !$data['username'] || !$data['role'] || !$data['active']) {
            return redirect()->to('/login');
        }

        if ($data['active'] != '1') {
            return redirect()->to('/login');
        }

        if ($data['id']) {
            // Ambil data active dari DB
            helper('function');
            $user = queryUserById($data['id']);

            if ($user['active'] != '1') {
                return redirect()->to('/logout');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
