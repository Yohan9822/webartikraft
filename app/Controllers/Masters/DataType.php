<?php

namespace App\Controllers\Masters;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\FileJsonObject;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\Sttype;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;

class DataType extends BaseController
{
    protected $type;

    protected $breadcrumb = [
        'Master',
        'Data Type'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/datatype');
        $this->type = new Sttype();
    }

    public function index()
    {
        $data['title'] = 'Data Type | Master';
        $data['section'] = 'Data Type';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/masters/datatypes/v_datatype', $data);
    }

    public function datatable()
    {
        $filter = (object) $this->getPost('filter');

        $datatables = Datatables::method([Sttype::class, 'getDataTable'], 'searchDataTable')
            ->setParams([$filter])
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->typeid);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Data Type - $db->typename",
                getURL("cms/datatype/form/$encryptId"),
                ['modalSize' => 'modal-md']
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Data Type - $db->typename",
                getURL('cms/datatype/delete'),
                ['id' => $encryptId]
            );

            return [
                $no,
                $db->typecode,
                $db->typename,
                $db->catname,
                dateFormat($db->createddate),
                $db->createdname,
                dateFormat($db->updateddate),
                $db->updatedname,
                implode("", [$btnEdit, $btnDelete])
            ];
        });

        return $datatables->toJson();
    }

    public function form($typeid = null)
    {
        $category = (object) json_decode($this->getPost('category'), '[]');

        $this->breadcrumb[] = 'Form';

        $data['access_code'] = AccessCode::create;
        $data['form_type'] = 'add';
        $data['title'] = 'Data Type | Master';
        $data['section'] = 'Data Type';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['category'] = $category;

        if (!empty($typeid)) {
            $row = $this->type->getOne(decrypting($typeid));
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

        $json['view'] = view('cms/masters/datatypes/v_datatype_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        $typename = $this->getPost('typename');
        $typecode = $this->getPost('typecode');
        $catname = decrypting($this->getPost('categ'));
        $file = $this->getFile('image');

        $validCode = $this->type->validCode($typecode);
        if (!$validCode) throw new Exception("Code has been used");

        $payload = (object) [];

        if (!is_null($file) && !$file->isValid())
            throw new \Exception("Invalid image");

        if (!is_null($file) && $file->isValid()) {
            $fileJson = new FileJsonObject();
            $fileJson->move($file, "uploads/sttype");
            $payload->logo = $fileJson->files();
        }

        $insert = [
            'typename' => $typename,
            'typecode' => $typecode,
            'catid' => $catname,
            'payload' => json_encode($payload),
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => getSession('userid'),
        ];

        $this->type->store($insert);

        return response()->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
            ]);
    }

    public function update()
    {
        $typeid = decrypting($this->getPost('typeid'));
        $typename = $this->getPost('typename');
        $typecode = $this->getPost('typecode');
        $catname = decrypting($this->getPost('categ'));
        $file = $this->getFile('image');
        $fileValue = $this->getPost('image_value');

        $validCode = $this->type->validCode($typecode, $typeid);
        if (!$validCode) throw new Exception("Code has been used");

        if (!is_null($file) && !$file->isValid())
            throw new \Exception("Invalid image");

        $row = $this->type->find($typeid);

        $payload = json_decode($row->payload ?? '{}');
        $editFileJson = new FileJsonObject($payload->logo ?? []);

        if (!is_null($file) && $file->isValid()) {
            $fileJson = new FileJsonObject();
            $fileJson->move($file, "uploads/sttype");
            $payload->logo = $fileJson->files();

            $editFileJson->removeAll();
        } else if (is_null($file) && empty($fileValue)) {
            $editFileJson->removeAll();

            $payload->logo = $editFileJson->files();
        }

        $update = [
            'typename' => $typename,
            'typecode' => $typecode,
            'catid' => $catname,
            'payload' => json_encode($payload),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => getSession('userid'),
        ];

        $this->type->edit($update, $typeid);

        return response()->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
            ]);
    }

    public function delete()
    {

        $id = decrypting($this->getPost('id'));

        $this->type->destroy($id);

        return response()->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
            ]);
    }

    public function apiGetType()
    {
        $options = (object) $this->getPost('options');
        $categoryCode = $this->getPost('category_code');
        $searchKey = strtolower(trim($this->getPost('term')));
        $results = $this->type->searchByCategory($categoryCode, $searchKey);

        $json['data'] = array_map(
            function ($result) use ($options) {
                $id = encrypting($result->typeid);
                if (!empty($options->value) && in_array($options->value, ['typecode']))
                    $id = $result->typecode;

                return [
                    'id' => $id,
                    'text' => $result->typename,
                ];
            },
            $results
        );

        return response()->setStatusCode(200)->setJSON($json);
    }

    public function apiGetByCategory($category)
    {
        $options = (object) $this->getPost('options');
        $notStatus = ['cart', 'waiting-payment'];
        $istype = strtolower($this->getGet('istype'));
        $searchKey = strtolower(trim($this->getPost('term')));
        $results = $this->type->searchByCategory($category, $searchKey);

        if ($istype === 'transtype') {
            $results = array_filter($results, function ($result) use ($notStatus) {
                return !in_array(strtolower($result->typecode), $notStatus);
            });
        }

        $json['data'] = array_map(
            function ($result) use ($istype, $options) {
                $id = encrypting($result->typeid);
                if (!empty($options->value) && in_array($options->value, ['typecode']))
                    $id = $result->typecode;

                if ($istype == 'transtype') $id = $result->typecode;

                return [
                    'id'   => $id,
                    'text' => $result->typename,
                ];
            },
            $results
        );

        return response()->setStatusCode(200)->setJSON($json);
    }
}
