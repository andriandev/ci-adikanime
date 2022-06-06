<?php

namespace App\Controllers;

use \App\Models\Post_Model;

class Post extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new Post_Model();
    }

    public function index($slug = false)
    {
        $cache = \Config\Services::cache();

        if (!$slug == cache($slug)) {
            // Mengambil data dari DB berdasarkan slug
            $post = $this->postModel->getPostbySlug($slug);

            // Mengambil data post random dari DB
            $posts = $this->postModel->getPostsRandom(10);

            // Cek apakah post ada tidak di DB atau status private/publish 
            if (!$post || $post['status'] != 'publish') {
                return view('pages/error');
            }

            // Include Soralink dan Enkripsi semua link
            require_once APPPATH . "/ThirdParty/soralink/sora_client_library.php";
            $post['content'] = sora_client_encrypt_content($post['content']);

            $data = [
                'title' => $post['title'],
                'post' => $post,
                'posts' => $posts
            ];

            // Save cache 7 hari
            $cache->save($slug, $data, 604800);
        } else {
            $data = $cache->get($slug);
        }

        return view('post/index', $data);
    }

    public function all($page = 1)
    {
        $limit = 10;
        $offset = $this->postModel->getOffset($page, $limit);
        $totalPost = $this->postModel->getCountAllPost();
        $totalPage = $this->postModel->getPageCount($totalPost, $limit);
        $postPublish = $this->postModel->getCountPost('publish');
        $postPrivate = $this->postModel->getCountPost('private');
        $data = [
            'title' => 'Index Post',
            'post' => $this->postModel->getAllPost($page, $limit),
            'offset' => $offset,
            'paginate' => printPagination('/post/all/', $page, $totalPage),
            'totalPost' => $totalPost,
            'totalPage' => $totalPage,
            'postPublish' => $postPublish,
            'postPrivate' => $postPrivate
        ];
        return view('post/all', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Post',
            'validation' => \Config\Services::validation()
        ];
        return view('post/create', $data);
    }

    public function save()
    {
        if (isset($_POST)) {
            if (!$this->validate([
                'title' => [
                    'rules' => 'required|is_unique[tb_post.title]',
                    'errors' => [
                        'required' => 'Judul harus di isi',
                        'is_unique' => 'Judul sudah ada di database'
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status harus di isi'
                    ]
                ],
                'content' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Konten harus di isi'
                    ]
                ],
                'url_request' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Konten harus di isi'
                    ]
                ]
            ])) {
                return redirect()->back()->withInput();
            }

            $title = $this->request->getVar('title');
            $slug = url_title($title, '-', true);
            $status = $this->request->getVar('status');
            $content = $this->request->getVar('content');
            $url_request = $this->request->getVar('url_request');

            $this->postModel->save([
                'id_user' => session()->get('id'),
                'title' => $title,
                'slug' => $slug,
                'status' => $status,
                'content' => $content,
                'url_request' => $url_request
            ]);

            // Session setFlashdata
            $pesan = '<div class="alert alert-success text-center" role="alert">
            Post Berhasil Ditambahkan.
            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/post/all');
        }
    }

    public function edit($slug = false)
    {
        // Cek user yang akan mengedit penulisnya atau bukan
        $post = $this->postModel->getPostbySlug($slug);
        if ($post['id_user'] != session()->get('id')) {
            // Session setFlashdata
            $pesan = '<div class="alert alert-danger text-center" role="alert">
            Akses ditolak.
            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/post/all');
        }

        $data = [
            'title' => 'Edit Post',
            'post' => $post,
            'validation' => \Config\Services::validation()
        ];
        return view('post/edit', $data);
    }

    public function update()
    {
        if (isset($_POST)) {
            $id = $this->request->getVar('id');
            $title = $this->request->getVar('title');
            $slug = $this->request->getVar('slug');
            $status = $this->request->getVar('status');
            $content = $this->request->getVar('content');
            $url_request = $this->request->getVar('url_request');

            // Mengambil data dari DB brdasarkan id
            $post = $this->postModel->getPostbyId($id);

            if ($post['slug'] == $slug) {
                $rulesSlug = 'required';
            } else {
                $rulesSlug = 'required|is_unique[tb_post.slug]';
            }

            if (!$this->validate([
                'title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul harus di isi'
                    ]
                ],
                'slug' => [
                    'rules' => $rulesSlug,
                    'errors' => [
                        'required' => 'Slug harus di isi',
                        'is_unique' => 'Slug sudah ada di database'
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status harus di isi'
                    ]
                ],
                'content' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Konten harus di isi'
                    ]
                ],
                'url_request' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Url request harus di isi'
                    ]
                ]
            ])) {
                return redirect()->back()->withInput();
            }

            // Cek user yang akan mengupdate penulisnya atau bukan
            if ($post['id_user'] != session()->get('id')) {
                // Session setFlashdata
                $pesan = '<div class="alert alert-danger text-center" role="alert">
                Akses ditolak.
                </div>';
                session()->setFlashdata('pesan', $pesan);

                return redirect()->to('/post/all');
            }

            $this->postModel->save([
                'id' => $id,
                'title' => $title,
                'slug' => $slug,
                'status' => $status,
                'content' => $content,
                'url_request' => $url_request,
            ]);

            // Session setFlashdata
            $pesan = '<div class="alert alert-warning text-center" role="alert">
            Post Berhasil Di Edit.
            </div>';
            session()->setFlashdata('pesan', $pesan);

            // Delete cache post
            $cache = \Config\Services::cache();
            $cache->delete($post['slug']);

            return redirect()->to('/post/all');
        }
    }

    public function delete($slug = false)
    {
        // Cek user yang akan mendelete penulisnya atau bukan
        $post = $this->postModel->getPostbySlug($slug);
        if ($post['id_user'] != session()->get('id')) {
            // Session setFlashdata
            $pesan = '<div class="alert alert-danger text-center" role="alert">
            Akses ditolak.
            </div>';
            session()->setFlashdata('pesan', $pesan);

            return redirect()->to('/post/all');
        }

        $this->postModel->where('slug', $slug)->delete();

        // Session setFlashdata
        $pesan = '<div class="alert alert-danger text-center" role="alert">
        Post Berhasil Di Hapus.
        </div>';
        session()->setFlashdata('pesan', $pesan);

        // Delete cahe post
        $cache = \Config\Services::cache();
        $cache->delete($post['slug']);

        return redirect()->to('/post/all');
    }
}
