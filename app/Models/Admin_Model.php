<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_Model extends Model
{
    // Variabel untuk DB yang akan digunakan
    protected $table = 'tb_users';
    protected $primaryKey = 'id';
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'password', 'email', 'role', 'active'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getOffset($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        return $offset;
    }

    public function getCountAllUser()
    {
        $countData = $this->countAll();
        return $countData;
    }

    public function getPageCount($countData, $limit)
    {
        $pageCount = ceil($countData / $limit);
        return $pageCount;
    }

    public function getAllUser($limit = 10, $offset = 0)
    {
        $user = $this->orderBy('created_at', 'DESC')->findAll($limit, $offset);
        return $user;
    }

    public function getUserByUsername($username)
    {
        $user = $this->where(['username' => $username])->get()->getResultArray();
        if ($user) {
            $user = $user[0];
        }
        return $user;
    }

    public function getUserById($id)
    {
        $user = $this->where(['id' => $id])->get()->getResultArray();
        if ($user) {
            $user = $user[0];
        }
        return $user;
    }
}
