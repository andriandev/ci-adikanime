<?php

namespace App\Models;

use CodeIgniter\Model;

class Post_Model extends Model
{
    // Variabel untuk DB yang akan digunakan
    protected $table = 'tb_post';
    protected $primaryKey = 'id';
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_user', 'title', 'slug', 'status', 'content', 'url_request'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getOffset($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        return $offset;
    }

    public function getCountAllPost()
    {
        $countData = $this->where('id_user', session()->get('id'))->countAllResults();
        return $countData;
    }

    public function getCountPost($status)
    {
        $countData = $this->where('id_user', session()->get('id'))->where('status', $status)->countAllResults();
        return $countData;
    }

    public function getPageCount($countData, $limit)
    {
        $pageCount = ceil($countData / $limit);
        return $pageCount;
    }

    public function getAllPost($page = 1, $limit = 10)
    {
        $data = $this->where('id_user', session()->get('id'))->orderBy('created_at', 'DESC')->findAll($limit, $this->getOffset($page, $limit));
        return $data;
    }

    public function getPostbySlug($slug)
    {
        $data = $this->where(['slug' => $slug])->get()->getResultArray();
        if ($data) {
            $data = $data[0];
        }
        return $data;
    }

    public function getPostbyId($id)
    {
        $data = $this->where(['id' => $id])->get()->getResultArray();
        if ($data) {
            $data = $data[0];
        }
        return $data;
    }

    public function getCountPostHome()
    {
        $countData = $this->countAllResults();
        return $countData;
    }

    public function getPostsRandom($limit)
    {
        $data = $this->select('title, slug')->orderBy('created_at', 'RANDOM')->limit($limit)->get()->getResultArray();
        return $data;
    }

    public function getPostHome($page = 1, $limit = 10)
    {
        $data = $this->select('title, slug')->orderBy('created_at', 'DESC')->findAll($limit, $this->getOffset($page, $limit));
        return $data;
    }
}
