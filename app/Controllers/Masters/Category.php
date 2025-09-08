<?php

namespace App\Controllers\Masters;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\Stcategory;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Category extends BaseController
{
    protected $category;

    protected $breadcrumb = [
        'Master',
        'Category'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/category');
        $this->category = new Stcategory();
    }

    public function index()
    {

        $data['title'] = 'Category | Master';
        $data['section'] = 'Category';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/masters/category/v_category', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([Stcategory::class, 'getDataTable'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->catid);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Category - $db->catname",
                getURL("cms/category/form/$encryptId"),
                ['modalSize' => 'modal-sm']
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Category - $db->catname",
                getURL('cms/category/delete'),
                ['id' => $encryptId]
            );

            return [
                $no,
                $db->catcode,
                $db->catname,
                dateFormat($db->createddate),
                $db->createdname,
                dateFormat($db->updateddate),
                $db->updatedname,
                implode('', [$btnEdit, $btnDelete])
            ];
        });
        return $datatables->toJson();
    }

    public function form($categoryid = null)
    {

        $data['form_type'] = 'add';
        $data['access_code'] = AccessCode::create;

        if (!empty($categoryid)) {
            $data['form_type'] = 'edit';
            $data['access_code'] = AccessCode::update;
            $data['row'] = $this->category->find(decrypting($categoryid));
        }

        if (!getAccess(AccessCode::update))
            throw new Exception("Permission Denied", 500);

        $json['view'] = view('cms/masters/category/v_category_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        $catcode = $this->getPost('catcode');
        $catname = $this->getPost('catname');

        $data = [
            'catcode' => $catcode,
            'catname' => $catname,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => getSession('userid'),
        ];

        $this->category->store($data);

        return response()->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
            ]);
    }

    public function update()
    {
        $catid = decrypting($this->getPost('catid'));
        $catcode = $this->getPost('catcode');
        $catname = $this->getPost('catname');

        $data = [
            'catcode' => $catcode,
            'catname' => $catname,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => getSession('userid'),
        ];

        $this->category->edit($data, $catid);

        return response()->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
            ]);
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

    public function apiGetCategory()
    {
        $searchValue = trim(strtolower($this->getPost('term')));

        $results = $this->category->search($searchValue);

        $json = array_map(
            function ($result) {
                return [
                    'id' => encrypting($result->catid),
                    'text' => $result->catname
                ];
            },
            $results
        );

        return response()->setJSON(['data' => $json]);
    }
}
