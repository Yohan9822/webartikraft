<?php

namespace App\Controllers\Masters;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Libraries\History\HistoryProcess;
use App\Libraries\History\src\Vars\MapAction;
use App\Libraries\History\src\Vars\MappingConfig;
use App\Models\Mscompany;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use TableName;

class Company extends BaseController
{
    protected $company;

    protected $breadcrumb = [
        'Master',
        'Company'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/company');

        $this->company = new Mscompany();
    }

    public function index()
    {
        $data['title'] = 'Company | Master';
        $data['section'] = 'Company';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/masters/company/v_company', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([Mscompany::class, 'getDataTable'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->companyid);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Company - $db->companyname",
                getURL("company/form/$encryptId")
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Company - $db->companyname",
                getURL("company/delete"),
                ['id' => $encryptId]
            );

            $btnHistory = ButtonComponents::historyDataTable(
                "History Company - $db->companyname",
                $encryptId,
                [encrypting(TableName::mscompany)],
                ['class' => 'btn-primary margin-r-2', 'visibility' => getAccess(AccessCode::history)]
            );

            return [
                $no,
                $db->companyname,
                $db->address,
                $db->createdby,
                dateFormat($db->createddate),
                $db->updatedby,
                dateFormat($db->updateddate),
                implode('', [$btnEdit, $btnDelete])
            ];
        });

        return $datatables->toJson();
    }

    public function form($companyid = null)
    {

        $data['form_type'] = 'add';
        $data['access_code'] = AccessCode::create;

        if (!empty($companyid)) {
            $data['form_type'] = 'edit';
            $data['access_code'] = AccessCode::update;
            $data['row'] = $this->company->find(decrypting($companyid));
        }

        if (!getAccess($data['access_code']))
            throw new Exception("Permission Denied", 500);

        $json['view'] = view('cms/masters/company/v_company_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        try {
            $companyname = $this->getPost('companyname');
            $address = $this->getPost('address');

            $data = [
                'companyname' => $companyname,
                'address' => $address,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => getSession('userid'),
            ];

            $this->db->transBegin();

            $this->company->store($data);

            $companyId = db_connect()->insertID();

            HistoryProcess::record(
                MappingConfig::mscompany($companyId),
                $data
            )->run();

            $this->db->transCommit();

            return response()->setStatusCode(200)
                ->setJSON([
                    'sukses' => 1,
                    'pesan' => 'Successfully'
                ]);
        } catch (AppException $e) {
            $this->db->transRollback();
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => $e->getMessage(),
                ]);
        }
    }

    public function update()
    {
        try {
            $companyid = decrypting($this->getPost('companyid'));
            $companyname = $this->getPost('companyname');
            $address = $this->getPost('address');

            $data = [
                'companyname' => $companyname,
                'address' => $address,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid')
            ];

            $this->db->transBegin();

            HistoryProcess::record(
                MappingConfig::mscompany($companyid, MapAction::update),
                $data
            )->run();

            $this->company->edit($data, $companyid);

            $this->db->transCommit();

            return response()->setStatusCode(200)
                ->setJSON([
                    'sukses' => 1,
                    'pesan' => 'Successfully'
                ]);
        } catch (AppException $e) {
            $this->db->transRollback();
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => $e->getMessage(),
                ]);
        }
    }

    public function delete()
    {
        try {
            $id = decrypting($this->getPost('id'));

            $this->db->transBegin();

            HistoryProcess::record(
                MappingConfig::mscompany($id, MapAction::delete)
            )->run();

            $this->company->destroy($id);

            $this->db->transCommit();

            return response()->setStatusCode(200)
                ->setJSON([
                    'sukses' => 1,
                    'pesan' => 'Successfully'
                ]);
        } catch (AppException $e) {
            $this->db->transRollback();
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => $e->getMessage(),
                ]);
        }
    }

    public function apiGetCompany()
    {
        $searchKey = trim(strtolower($this->getPost('term')));
        $results = $this->company->search($searchKey);

        $json['data'] = array_map(
            function ($result) {
                return [
                    'id' => encrypting($result->companyid),
                    'text' => $result->companyname,
                ];
            },
            $results,
        );

        return response()->setJSON($json);
    }
}
