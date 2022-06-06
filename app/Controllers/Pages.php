<?php

namespace App\Controllers;

use \App\Models\Post_Model;

class Pages extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new Post_Model();
    }

    public function home($page = 1)
    {
        // Mengambil data post dari DB
        $limit = 10;
        $totalPost = $this->postModel->getCountPostHome();
        $totalPage = $this->postModel->getPageCount($totalPost, $limit);
        $posts = $this->postModel->getPostHome($page, $limit);

        $data = [
            'title' => 'Homepage',
            'posts' => $posts,
            'paginate' => printPagination('/', $page, $totalPage)
        ];
        return view('pages/home', $data);
    }
}
