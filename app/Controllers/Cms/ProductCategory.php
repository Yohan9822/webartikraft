<?php

namespace App\Controllers\Cms;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\Cmsproduct;
use App\Models\Cmsproductcategory;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use FormComponents;

class ProductCategory extends BaseController
{
    protected $category;

    protected $breadcrumb = [
        'Cms',
        'Product Category'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/categoryproduct');
        $this->category = new Cmsproductcategory();
    }

    public function index()
    {
        $data['title'] = 'Product Category | Cms';
        $data['section'] = 'Product Category';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/categoryproduct/v_category', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([Cmsproductcategory::class, 'getDataTable'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->id);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Category Product",
                getURL("cms/categoryproduct/form/$encryptId"),
                ['modalSize' => 'modal-md']
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Product",
                getURL('cms/categoryproduct/delete'),
                ['id' => $encryptId]
            );

            $cellIsActive = FormComponents::builder(
                'category-image',
                FormComponents::checkbox('isactive', [
                    'checked' => $db->isactive == 't',
                    'attributes' => [
                        'data-id' => $encryptId,
                        'data-column' => 'isactive',
                    ]
                ])
            );

            return [
                $no,
                $db->categoryname,
                $cellIsActive,
                "<div class='dflex flex-column'>
                    <span class='text-primary fw-semibold'>" . $db->createdname . "</span>
                    <span class='text-secondary'>" . dateFormat($db->createddate) . "</span>
                </div>",
                "<div class='dflex flex-column'>
                    <span class='text-primary fw-semibold'>" . $db->updatedname . "</span>
                    <span class='text-secondary'>" . dateFormat($db->updateddate) . "</span>
                </div>",
                implode('', [$btnEdit, $btnDelete])
            ];
        });
        return $datatables->toJson();
    }

    public function form($id = null)
    {
        $category = (object) json_decode($this->getPost('category'), '[]');

        $this->breadcrumb[] = 'Form';

        $data['access_code'] = AccessCode::create;
        $data['form_type'] = 'add';
        $data['title'] = 'Category Product | CMS';
        $data['section'] = 'Category Product';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['category'] = $category;

        if (!empty($id)) {
            $row = $this->category->find(decrypting($id));

            $data['form_type'] = 'edit';
            $data['access_code'] = AccessCode::update;
            $data['row'] = $row;
        }

        if (!getAccess($data['access_code']))
            throw new \Exception("Access Denied", 500);

        if ($data['form_type'] == 'edit' && empty($data['row']))
            throw new \Exception("Invalid data", 500);

        $json['view'] = view('cms/categoryproduct/v_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        $category = $this->getPost('categoryname');

        $this->db->transBegin();
        try {
            if (empty($category)) throw new Exception("Product Category is required!");

            $insert = [
                'categoryname' => $category,
                'isactive' => true,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => getSession('userid')
            ];

            $this->category->store($insert);

            $this->db->transCommit();
            return $this->response->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
                'dbError' => db_connect()->error()
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'sukses' => 0,
                'pesan' => $e->getMessage(),
                'dbError' => db_connect()->error()
            ]);
        }
    }

    public function update()
    {
        $id = decrypting($this->getPost('id'));
        $category = $this->getPost('categoryname');

        $this->db->transBegin();
        try {
            if (empty($category)) throw new Exception("Product Category is required!");

            // $row = $this->category->find($id);

            $update = [
                'categoryname' => $category,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid')
            ];

            $this->category->edit($update, $id);

            $this->db->transCommit();
            return $this->response
                ->setJSON([
                    'sukses' => 1,
                    'pesan' => 'Successfully'
                ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => $e->getMessage(),
                    'dbError' => db_connect()->error()
                ]);
        }
    }

    public function delete()
    {
        $id = decrypting($this->getPost('id'));

        $this->category->destroy($id);

        return response()->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
            ]);
    }

    public function updateField()
    {
        $id = decrypting($this->getPost('id'));
        $column = $this->getPost('column');
        $value = $this->getPost('value');

        $updates[$column] = $value;
        $updates['updatedby'] = getSession('userid');
        $updates['updateddate'] = date('Y-m-d H:i:s');

        $this->category->edit($updates, $id);

        return $this->response->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }
}
