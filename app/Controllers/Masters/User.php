<?php

namespace App\Controllers\Masters;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Libraries\History\HistoryProcess;
use App\Libraries\History\src\Vars\MapAction;
use App\Libraries\History\src\Vars\MappingConfig;
use App\Models\Msaccessgroup;
use App\Models\Msuser;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use FormComponents;
use TableName;

class User extends BaseController
{
    protected $accgroup;

    protected $breadcrumb = [
        'Master',
        'Users'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/user');

        $this->user = new Msuser;
        $this->accgroup = new Msaccessgroup;
    }

    public function index()
    {
        $data['title'] = 'User | Master';
        $data['section'] = 'User';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/masters/user/v_user', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([Msuser::class, 'getDataTable'], 'searchDataTable')
            ->make();
        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->userid);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update User - $db->name",
                getURL("cms/user/form/$encryptId")
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete User - $db->name",
                getURL("cms/user/delete"),
                ['id' => $encryptId]
            );

            $btnGroup = ButtonComponents::modalDataTable(
                "<i class=\"bx bx-group\"></i> <span>Groups</span>",
                "User Group Setting - $db->name",
                getURL("cms/user/access"),
                ['data' => ['userid' => $encryptId], 'class' => 'btn-primary margin-r-2']
            );

            $btnHistory = ButtonComponents::historyDataTable(
                "History User - $db->name",
                $encryptId,
                [encrypting(TableName::msuser), encrypting(TableName::msusergroup)],
                ['class' => 'btn-primary margin-r-2']
            );

            $cellIsActive = FormComponents::builder(
                'user',
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
                $db->name,
                $db->username,
                $db->createdname,
                dateFormat($db->createddate),
                $db->updatedname,
                dateFormat($db->updateddate),
                $cellIsActive,
                implode("", [$btnGroup, $btnEdit, $btnDelete])
            ];
        });
        return $datatables->toJson();
    }

    public function forms($id = null)
    {
        $id = decrypting($id);

        $data['form_type'] = 'add';
        $data['access_code'] = AccessCode::create;

        if (!empty($id)) {
            $data['form_type'] = 'edit';
            $data['access_code'] = AccessCode::update;
            $data['row'] = $this->user->find($id);
        }

        $json['view'] = view('cms/masters/user/v_form', $data);

        return $this->response->setJSON($json);
    }

    public function add()
    {
        $name = $this->getPost('name');
        $username = $this->getPost('username');
        $username_lama = $this->getPost('username_old');
        $password = $this->getPost('password');
        $password_lama = $this->getPost('password_lama');

        $validation = \Config\Services::validation();
        // $valid = $this->validate([
        //     'username' => [
        //         'rules' => 'is_unique[master.msuser.username]',
        //         'label' => 'Username',
        //         'errors' => [
        //             'is_unique' => '{field} sudah terdaftar'
        //         ]
        //     ]
        // ]);

        // if (!$valid)
        //     throw new \Exception($validation->getError('username'));

        $data = [
            'name' => $name,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'isactive' => true,
            'createdby' => getSession('userid'),
            'createddate' => date('Y-m-d H:i:s'),
        ];

        $this->user->store($data);

        $userid = db_connect()->insertID();

        HistoryProcess::record(MappingConfig::msuser($userid), $data)
            ->run();

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function update()
    {
        $id = decrypting($this->getPost('id'));

        $name = $this->getPost('name');
        $username = $this->getPost('username');
        $username_lama = $this->getPost('username_old');
        $password = $this->getPost('password');
        $password_lama = $this->getPost('password_lama');

        $pass = $password_lama;

        if ($password != '') {
            $pass = password_hash($password, PASSWORD_DEFAULT);
        }

        $rule_username = [];
        $validation = \Config\Services::validation();
        if ($username != $username_lama) {
            // $rule_username = [
            //     'rules' => 'is_unique[msuser.username]',
            //     'label' => 'Username',
            //     'errors' => [
            //         'required' => "{field} dibutuhkan",
            //         'is_unique' => '{field} sudah terdaftar'
            //     ]
            // ];
        }
        $valid = $this->validate([
            'username' => $rule_username
        ]);

        if (!$valid)
            throw new \Exception($validation->getError('username'));

        $updates = [
            'name' => $name,
            'username' => $username,
            'password' => $pass,
            'updatedby' => getSession('userid'),
            'updateddate' => date('Y-m-d H:i:s')
        ];

        HistoryProcess::record(MappingConfig::msuser($id, MapAction::update), $updates)
            ->run();

        $this->user->edit($updates, $id);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function delete()
    {
        $id = decrypting($this->getPost('id'));

        HistoryProcess::record(MappingConfig::msuser($id, MapAction::delete))
            ->run();

        $this->user->destroy($id);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function formGroups()
    {
        $userid = decrypting($this->getPost('userid'));

        $datas['userid'] = $userid;

        $json['view'] = view('cms/masters/user/v_groups', $datas);

        return response()->setJSON($json);
    }

    public function datatableGroups()
    {
        $userid = decrypting($this->getPost('userid'));

        $table = Datatables::method([Msaccessgroup::class, 'getDataTable'], 'searchDataTable')
            ->setParams([$userid])
            ->make();

        $table->updateRow(function ($db, $nomor) {
            $encryptId = encrypting($db->accessgroupid);
            $encryptUserId = encrypting($db->userid);

            $checked = $db->isdefault == 't' ? 'checked' : '';

            $listMenus = array_map(
                function ($menu) {
                    return "<div class=\"label label-secondary margin-l-2\" style=\"margin-bottom: 5px;\">$menu->menuname</div>";
                },
                json_decode($db->list_menu ?? '[]')
            );

            $isDefault = "<div class='dflex align-center justify-center'>
                    " . (getAccess(AccessCode::delete) ? "<i class=\"bx bxs-x-circle text-danger\" style='cursor: pointer;' onclick=\"deleteAccess('$encryptId', '$encryptUserId')\"></i>" : '') . "
                    <input type='checkbox' value='" . $db->isdefault . "' style='cursor: pointer;' class=\"centang\" onclick=\"change_default($nomor, '$encryptId')\" id='centang$nomor' $checked> Is Default
                </div>";
            if (!getAccess(AccessCode::update)) $isDefault = '';

            return [
                $nomor,
                $db->groupname,
                $db->typename,
                "<div class=\"dflex\">" . implode("", $listMenus) . "</div>",
                $db->companyname,
                $isDefault
            ];
        });
        $table->toJson();
    }

    public function addGroups()
    {
        $userid = decrypting($this->getPost('userid'));
        $checkdefault = $this->accgroup->checkIsDefault($userid);
        $companyid = decrypting($this->getPost('companyid'));
        $usergroupid = decrypting($this->getPost('usergroupid'));
        $usertype = decrypting($this->getPost('usertype'));

        $isdefault = 'f';
        if (empty($checkdefault->isdefault)) $isdefault = 't';

        $insert = [
            'userid' => $userid,
            'usergroupid' => $usergroupid,
            "companyid" => $companyid,
            "usertypeid" => $usertype,
            "isdefault" => $isdefault,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => getSession('userid'),
            'isactive' => 't'
        ];
        $checkaccess = $this->accgroup->checkAccessgroup($userid, $usergroupid, $companyid);
        if (is_null($checkaccess)) {
            $this->accgroup->store($insert);

            $usergroupid = db_connect()->insertID();

            HistoryProcess::record(MappingConfig::msaccessgroup($userid, MapAction::add, $usergroupid), $insert)
                ->run();
        }

        return response()->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }

    public function updateGroups()
    {

        $accessgroupid = decrypting($this->getPost('accessid'));
        $userid = decrypting($this->getPost('userid'));

        $data = [
            'isdefault' => 't',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
        ];

        $updateDetaultFalse = $this->accgroup->edit(['isdefault' => 'f'], $userid, 'userid');
        if ($updateDetaultFalse) {
            HistoryProcess::record(
                MappingConfig::msaccessgroup($userid, MapAction::update, $accessgroupid),
                $data
            )->run();
            $this->accgroup->edit($data, $accessgroupid);
        }

        return response()->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }

    public function deleteGroups()
    {
        $userid = decrypting($this->getPost('userid'));
        $accessgroupid = decrypting($this->getPost('accessgroupid'));

        HistoryProcess::record(
            MappingConfig::msaccessgroup($userid, MapAction::delete, $accessgroupid),
        )->run();

        $this->accgroup->destroy($accessgroupid);

        return response()->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
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

        $this->user->edit($updates, $id);

        return $this->response->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }
}
