<?php

namespace App\Controllers\Cms;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\Privileges\PrivilegesUser;
use App\Models\CmsBamboo;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ContentBamboo extends BaseController
{
    protected $bamboo;

    protected $breadcrumb = [
        'Cms',
        'Content Bamboo'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/bamboo');
        $this->bamboo = new CmsBamboo();
    }

    public function index()
    {
        $data['title'] = 'Content Bamboo | Cms';
        $data['section'] = 'Content Bamboo';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['row'] = $this->bamboo->getDefaultContent();

        return view('cms/contentbamboo/v_bamboo', $data);
    }

    public function add()
    {
        if (!getAccess(AccessCode::create))
            throw new Exception("Permission Denied");

        $content = $this->getPost('content_bamboo');

        $this->db->transBegin();
        try {
            if (empty($content)) throw new Exception("Content is required");

            $this->bamboo->store([
                'content' => $content,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => getSession('userid'),
            ]);

            $this->db->transCommit();
            return $this->response->setJSON([
                'sukses' => '1',
                'pesan' => 'Data has been saved',
                'dbError' => $this->db->error()
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'sukses' => '0',
                'pesan' => $e->getMessage(),
                'dbError' => $this->db->error()
            ]);
        }
    }

    public function update()
    {
        if (!getAccess(AccessCode::update))
            throw new Exception("Permission Denied");

        $id = decrypting($this->getPost('id'));
        $content = $this->getPost('content_bamboo');

        $this->db->transBegin();
        try {
            $this->bamboo->edit([
                'content' => $content,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid'),
            ], $id);

            $this->db->transCommit();
            return $this->response->setJSON([
                'sukses' => '1',
                'pesan' => 'Data has been updated',
                'dbError' => $this->db->error()
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'sukses' => '0',
                'pesan' => $e->getMessage(),
                'dbError' => $this->db->error()
            ]);
        }
    }

    public function delete()
    {
        if (!getAccess(AccessCode::delete))
            throw new Exception("Permission Denied");

        $id = decrypting($this->getPost('id'));

        $this->bamboo->destroy($id);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function uploadEditor()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'uploaded' => false,
                'error' => ['message' => 'Invalid request method.']
            ]);
        }

        $file = $this->request->getFile('upload');
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'uploaded' => false,
                'error' => ['message' => $file->getErrorString()]
            ]);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON([
                'uploaded' => false,
                'error' => ['message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.']
            ]);
        }

        $uploadPath = FCPATH . 'public/uploads/bamboo/';
        validate_dir($uploadPath);

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $fileUrl = base_url('public/uploads/bamboo/' . $newName);

        return $this->response->setJSON([
            'uploaded' => true,
            'url' => $fileUrl
        ]);
    }

    public function browserEditor()
    {
        $directory = FCPATH . 'public/uploads/bamboo/';
        $files = [];

        if (is_dir($directory)) {
            $scan = scandir($directory);
            foreach ($scan as $file) {
                if ($file !== '.' && $file !== '..') {
                    $files[] = [
                        'url' => base_url('public/uploads/bamboo/' . $file),
                        'name' => $file
                    ];
                }
            }
        }

        return view('cms/file_browser', ['files' => $files]);
    }
}
