<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Is_admin implements FilterInterface
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

        if ($data['active'] != '1' || $data['role'] != 'admin') {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
