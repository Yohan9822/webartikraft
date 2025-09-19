<?php

namespace App\Controllers\Cms;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\FileJsonObject;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\Cmsproduct;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use FormComponents;

class Products extends BaseController
{
    protected $product;

    protected $breadcrumb = [
        'Cms',
        'Products'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/products');
        $this->product = new Cmsproduct();
    }

    public function index()
    {
        $data['title'] = 'Products | Cms';
        $data['section'] = 'Products';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/products/v_product', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([Cmsproduct::class, 'getDataTable'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->id);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Product",
                getURL("cms/products/form/$encryptId"),
                ['modalSize' => 'modal-lg']
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Product",
                getURL('cms/products/delete'),
                ['id' => $encryptId]
            );

            $cellIsActive = FormComponents::builder(
                'products-image',
                FormComponents::checkbox('isactive', [
                    'checked' => $db->isactive == 't',
                    'attributes' => [
                        'data-id' => $encryptId,
                        'data-column' => 'isactive',
                    ]
                ])
            );

            $db->payload = json_decode($db->payload ?? '{}');

            $logos = files_preview($db->payload->logo);
            $db->payload->logo = array_shift($logos);

            return [
                $no,
                "<div class='dflex align-cente justify-center'>
                    <div style='width: 120px;height:120px;background-color:rgba(214, 224, 206);padding:4px;border-radius:4px;overflow:hidden;display:flex;justify-content: center;align-items:center;'>
                        <img src='" . $db->payload->logo . "' alt='slide images' style='width:100%;height:100%;object-fit:contain;'>
                    </div>
                </div>",
                $db->categoryname,
                $db->productname,
                $db->dimension,
                ucwords($db->materialname),
                "<div class='text-end'>" . currency($db->price ?? 0) . "</div>",
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
        $data['title'] = 'Products | CMS';
        $data['section'] = 'Products';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['category'] = $category;

        if (!empty($id)) {
            $row = $this->product->find(decrypting($id));
            $row->payload = json_decode($row->payload ?? '{}');

            if (!empty($row->payload->logo))
                $row->payload->logo = json_encode(files_preview($row->payload->logo));

            $data['form_type'] = 'edit';
            $data['access_code'] = AccessCode::update;
            $data['row'] = $row;
        }

        if (!getAccess($data['access_code']))
            throw new \Exception("Access Denied", 500);

        if ($data['form_type'] == 'edit' && empty($data['row']))
            throw new \Exception("Invalid data", 500);

        $json['view'] = view('cms/products/v_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        $file = $this->getFile('image');
        $category = $this->getPost('category');
        $productname = $this->getPost('productname');
        $price = $this->getPost('price');
        $material = $this->getPost('material');
        $dimension = $this->getPost('dimension');
        $description = $this->getPost('description');

        $this->db->transBegin();
        try {
            $payload = (object) [];

            if (empty($category)) throw new Exception("Product Category is required!");
            if (empty($productname)) throw new Exception("Product name is not filled!");
            if (empty($material)) throw new Exception("Material is required!");
            if (is_null($file)) throw new Exception("Images required for product");
            if (!is_null($file) && !$file->isValid())
                throw new \Exception("Invalid image");

            if (!is_null($file) && $file->isValid()) {
                $fileJson = new FileJsonObject();
                $fileJson->move($file, "uploads/products");
                $payload->logo = $fileJson->files();
            }

            $category = decrypting($category);
            $material = decrypting($material);

            $insert = [
                'category' => $category,
                'productname' => $productname,
                'material' => $material,
                'dimension' => $dimension ?? null,
                'description' => $description ?? null,
                'price' => removeIdr($price ?? 0),
                'payload' => json_encode($payload),
                'isactive' => true,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => getSession('userid')
            ];

            $this->product->store($insert);

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
        $file = $this->getFile('image');
        $fileValue = $this->getPost('image_value');
        $category = $this->getPost('category');
        $productname = $this->getPost('productname');
        $price = $this->getPost('price');
        $material = $this->getPost('material');
        $dimension = $this->getPost('dimension');
        $description = $this->getPost('description');

        $this->db->transBegin();
        try {
            if (empty($category)) throw new Exception("Product Category is required!");
            if (empty($productname)) throw new Exception("Product name is not filled!");
            if (empty($material)) throw new Exception("Material is required!");
            if (is_null($fileValue)) throw new Exception("Images required for product");
            if (!is_null($file) && !$file->isValid())
                throw new \Exception("Invalid image");

            $category = decrypting($category);
            $material = decrypting($material);

            $row = $this->product->find($id);

            $payload = json_decode($row->payload ?? '{}');
            $editFileJson = new FileJsonObject($payload->logo ?? []);

            if (!is_null($file) && $file->isValid()) {
                $fileJson = new FileJsonObject();
                $fileJson->move($file, "uploads/products");
                $payload->logo = $fileJson->files();

                $editFileJson->removeAll();
            } else if (is_null($file) && empty($fileValue)) {
                $editFileJson->removeAll();

                $payload->logo = $editFileJson->files();
            }

            $update = [
                'category' => $category,
                'productname' => $productname,
                'material' => $material,
                'dimension' => $dimension ?? null,
                'description' => $description ?? null,
                'price' => removeIdr($price ?? 0),
                'payload' => json_encode($payload),
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid')
            ];

            $this->product->edit($update, $id);

            if (!db_connect()->affectedRows()) {
                log_message('debug', $this->db->getLastQuery()->getQuery());
            }

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

        $this->product->destroy($id);

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

        $this->product->edit($updates, $id);

        return $this->response->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }
}
