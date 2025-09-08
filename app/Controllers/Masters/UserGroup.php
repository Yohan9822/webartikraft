<?php

namespace App\Controllers\Masters;

use App\Controllers\BaseController;
use App\Helpers\Menu\RenderMenu;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\Msaccessmenu;
use App\Models\Msmenu;
use App\Models\Msusergroup;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;

class UserGroup extends BaseController
{
    protected $group;
    protected $menu;
    protected $accessmenu;

    protected $breadcrumb = [
        'Master',
        'User Group',
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/usergroup');

        $this->group = new Msusergroup();
        $this->menu = new Msmenu();
        $this->accessmenu = new Msaccessmenu();
    }

    public function index()
    {
        $data['title'] = 'User Group | Master';
        $data['section'] = 'User Group';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/masters/usergroup/v_usergroup', $data);
    }

    public function datatable()
    {
        $table = Datatables::method([Msusergroup::class, 'getTable'], 'searchable')
            ->make();
        $table->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->groupid);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update User Group - $db->groupname",
                getURL("cms/usergroup/form/$encryptId"),
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete User Group - $db->groupname",
                getURL("cms/usergroup/delete"),
                ['id' => $encryptId, 'pagetype' => 'table']
            );

            $btnAccess = ButtonComponents::modalDataTable(
                "<i class=\"bx bxs-user-detail\"></i> <span>Privilleges</span>",
                "Update Access - $db->groupname",
                getURL('cms/usergroup/privileges'),
                ['data' => ['id' => $encryptId], "class" => "btn-primary margin-r-2"]
            );

            return [
                $no,
                $db->groupname,
                $db->createdby,
                dateFormat($db->createddate),
                $db->updatedby,
                dateFormat($db->updateddate),
                implode("", [$btnAccess, $btnEdit, $btnDelete])
            ];
        });
        $table->toJson();
    }

    public function forms($groupid = null)
    {

        $data['form_type'] = 'add';

        if (!empty($groupid)) {
            $data['form_type'] = 'edit';
            $data['row'] = $this->group->find(decrypting($groupid));
        }

        $d['view'] = view('cms/masters/usergroup/v_form', $data);

        return $this->response->setJSON($d);
    }

    public function add()
    {
        $groupname = $this->getPost('groupname');

        $data = [
            'groupname' => $groupname,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => getSession('userid'),
        ];

        $this->group->store($data);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function update()
    {
        $groupid = decrypting($this->getPost('groupid'));
        $groupname = $this->getPost('groupname');

        $data = [
            'groupname' => $groupname,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => getSession('userid')
        ];

        $this->group->edit($data, $groupid);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function delete()
    {
        $id = decrypting($this->getPost('id'));

        $this->group->destroy($id);
        $this->accessmenu->deleteByParam('usergroupid', $id);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function formPrivileges()
    {
        try {
            $id = decrypting($this->getPost('id'));

            $row = $this->group->find($id);

            if (is_null($row))
                throw new \Exception("InvalidData: Please check your data");

            $menus = $this->menu->getAccessGroup($id);

            $data['id'] = $id;
            $data['row'] = $row;
            $data['menus'] = new RenderMenu($menus);

            $json['view'] = view('cms/masters/usergroup/v_privileges', $data);

            return $this->response->setJSON($json);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 1,
                    'pesan' => $e->getMessage(),
                ]);
        }
    }

    public function updatePrivileges()
    {
        $this->db->transBegin();
        try {
            $id = decrypting($this->getPost('id'));
            $privileges = json_decode($this->getPost('privileges'));

            $insertData = [];
            $deleteData = [];
            foreach ($privileges as $privilege) {
                if (!$privilege->checked && !empty($privilege->accessid)) {
                    $deleteData[] = $privilege->accessid;
                } else if ($privilege->checked && empty($privilege->accessid)) {
                    $insertData[] = [
                        'usergroupid' => $id,
                        'menuid' => $privilege->menuid,
                        'componentid' => $privilege->componentid,
                        'createdby' => getSession('userid'),
                        'createddate' => date('Y-m-d H:i:s'),
                        'updatedby' => getSession('userid'),
                        'updateddate' => date('Y-m-d H:i:s'),
                    ];
                }
            }


            if (count($insertData) > 0) {
                $this->accessmenu->storeBatch($insertData);
            }

            if (count($deleteData) > 0) {
                $this->accessmenu->deleteBatch($deleteData);
            }

            $this->db->transCommit();
            return $this->response->setJSON([
                'sukses' => 1,
                'pesan' => 'Data berhasil diupdate',
                'csrfToken' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setStatusCode(200)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => $e->getMessage(),
                    'csrfToken' => csrf_hash(),
                    'trace' => $e->getTrace()
                ]);
        }
    }

    public function apiGetUserGroup()
    {
        $searchKey = trim(strtolower($this->getPost('term')));
        $results = $this->group->search($searchKey);

        $json['data'] = array_map(
            function ($result) {
                return [
                    'id' => encrypting($result->groupid),
                    'text' => $result->groupname,
                ];
            },
            $results
        );

        return response()->setJSON($json);
    }
}
