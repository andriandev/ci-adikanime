<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth_Model extends Model
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

    public function getUser($username)
    {
        $user = $this->where(['username' => $username])->get()->getResultArray();
        if ($user) {
            $user = $user[0];
        }
        return $user;
    }
}
