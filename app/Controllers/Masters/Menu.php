<?php

namespace App\Controllers\Masters;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\Menu\MenuArray;
use App\Libraries\Datatables\Datatables;
use App\Models\Mscomponent;
use App\Models\Msmenu;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use FormComponents;

class Menu extends BaseController
{
    protected $component;
    protected $menu;

    protected $breadcrumbs = [
        'Master',
        'Menu'
    ];

    public function __construct()
    {
        sessionMenu('cms/menu');

        $this->menu = new Msmenu();
        $this->component = new Mscomponent();
    }

    public function index()
    {
        $data['title'] = 'Menu | Master';
        $data['section'] = 'Menu';
        $data['breadcrumb'] = $this->breadcrumbs;

        return view('cms/masters/menus/v_menu', $data);
    }

    public function getTable()
    {
        $datatables = Datatables::method([Msmenu::class, 'getDataTables'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->menuid);

            $btnFeatures = ButtonComponents::modalDataTable(
                "<i class=\"bx bx-task\"></i> Features",
                "Features Menu - $db->menuname",
                getURL("cms/menu/features"),
                [
                    'id' => $encryptId,
                    'class' => 'btn-primary margin-r-2',
                    'data' => [
                        'menuid' => $encryptId,
                    ]
                ]
            );

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Menu - $db->menuname",
                getURL("cms/menu/form/$encryptId")
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Menu - $db->menuname",
                getURL('cms/menu/delete'),
                ['id' => $encryptId]
            );

            return [
                $no,
                $db->menuname,
                $db->mastername,
                $db->menulink,
                "<i class='" . $db->menuicon . "'></i>",
                implode('', [$btnFeatures, $btnEdit, $btnDelete])
            ];
        });

        return $datatables->toJson();
    }

    public function form($menuid = null)
    {
        $data['form_type'] = 'add';
        $data['access_code'] = AccessCode::create;

        if (!is_null($menuid)) {
            $data['form_type'] = 'edit';
            $data['access_code'] = AccessCode::update;
            $data['row'] = $this->menu->getOne(decrypting($menuid));

            if (is_null($data['row']))
                return $this->response->setStatusCode(500)
                    ->setJSON(['pesan' => 'Invalid data menu']);
        }

        if (!getAccess($data['access_code']))
            throw new Exception("Permission denied", 500);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'view' => view('cms/masters/menus/v_form', $data)
            ]);
    }

    public function add()
    {
        if (!getAccess(AccessCode::create))
            throw new Exception("Permission Denied");

        $masterid = decrypting($this->getPost('masterid'), null);
        $menuname = $this->getPost('menuname');
        $menulink = $this->getPost('menulink');
        $menuicon = $this->getPost('menuicon');

        $inserts = [
            'masterid' => $masterid,
            'menuname' => $menuname,
            'menulink' => $menulink,
            'menuicon' => $menuicon,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => getSession('userid'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => getSession('userid')
        ];

        $this->menu->store($inserts);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function update()
    {
        if (!getAccess(AccessCode::update))
            throw new Exception("Permission Denied");

        $menuid = decrypting($this->getPost('menuid'));
        $masterid = decrypting($this->getPost('masterid'), null);
        $menuname = $this->getPost('menuname');
        $menulink = $this->getPost('menulink');
        $menuicon = $this->getPost('menuicon');

        $updates = [
            'masterid' => $masterid,
            'menuname' => $menuname,
            'menulink' => $menulink,
            'menuicon' => $menuicon,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => getSession('userid')
        ];

        $this->menu->edit($updates, $menuid);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function destroy()
    {
        if (!getAccess(AccessCode::delete))
            throw new Exception("Permission Denied");

        $menuid = decrypting($this->getPost('id'));

        $this->menu->destroy($menuid);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function getSelectMaster()
    {
        $search = $this->getPost('term');
        $menus = $this->menu->getMaster($search);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'data' => array_map(
                    function ($menu) {
                        return [
                            'id' => encrypting($menu->menuid),
                            'text' => $menu->menuname,
                        ];
                    },
                    $menus,
                )
            ]);
    }

    public function formSort()
    {
        $data['menus'] = new MenuArray($this->menu->all());

        return $this->response->setJSON([
            'view' => view('cms/masters/menus/v_menu_sort', $data)
        ]);
    }

    public function updateSort()
    {
        try {
            if (!getAccess(AccessCode::update))
                throw new Exception("Permission Denied");

            $menus = $this->getPost('menus');

            $this->menu->updateJson($menus);

            return $this->response->setJSON([
                'sukses' => 1,
                'pesan' => 'Sorting successfully',
                'csrfToken' => csrf_hash(),
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => $e->getMessage(),
                    'csrfToken' => csrf_hash(),
                    'trace' => $e->getTrace(),
                ]);
        }
    }

    public function formFeatures()
    {
        $menuid = decrypting($this->getPost('menuid'));

        $data['menuid'] = $menuid;

        return $this->response->setJSON([
            'view' => view('cms/masters/menus/v_menu_features', $data)
        ]);
    }

    public function getTableFeatures()
    {
        $menuid = decrypting($this->getPost('menuid'));

        $datatables = Datatables::method([Mscomponent::class, 'getDataTatables'], 'searchDataTables')
            ->setParams([$menuid])
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->componentid);

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Features - $db->componentname",
                getURL('cms/menu/features/delete'),
                ['id' => $encryptId]
            );

            $cellIsActive = FormComponents::builder(
                'feature',
                FormComponents::checkbox('isactive', [
                    'checked' => $db->isactive == 't',
                    'attributes' => [
                        'data-id' => $encryptId,
                        'data-column' => 'isactive'
                    ]
                ])
            );

            return [
                $no,
                $db->componentcode,
                $db->componentname,
                $db->description,
                $cellIsActive,
                implode('', [$btnDelete])
            ];
        });

        return $datatables->toJson();
    }

    public function addFeatures()
    {
        if (!getAccess(AccessCode::create))
            throw new Exception("Permission Denied");

        $menuid = decrypting($this->getPost('menuid'));
        $code = $this->getPost('code');
        $name = $this->getPost('name');
        $description = $this->getPost('description');

        $this->component->store([
            'menuid' => $menuid,
            'componentcode' => $code,
            'componentname' => $name,
            'description' => $description,
            'isactive' => true,
            'createdby' => getSession('userid'),
            'createddate' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function deleteFeatures()
    {
        if (!getAccess(AccessCode::delete))
            throw new Exception("Permission Denied");

        $id = decrypting($this->getPost('id'));

        $this->component->destroy($id);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function addTemplateFeatures()
    {
        if (!getAccess(AccessCode::create))
            throw new Exception("Permission Denied");

        $menuid = decrypting($this->getPost('menuid'));
        $templatekey = $this->getPost('templatekey');

        $templates = [
            'view' => [
                (object) ['code' => 'view', 'name' => 'View', 'description' => 'View feature menu'],
            ],
            'crud' => [
                (object) ['code' => 'view', 'name' => 'View', 'description' => 'View menu'],
                (object) ['code' => 'create', 'name' => 'Create', 'description' => 'Create data feature'],
                (object) ['code' => 'update', 'name' => 'Update', 'description' => 'Update data feature'],
                (object) ['code' => 'delete', 'name' => 'Delete', 'description' => 'Delete data feature'],
            ],
            'import-excel' => [
                (object) ['code' => 'import-excel', 'name' => 'Import Excel', 'description' => 'Import from excel feature'],
            ],
            'export-excel' => [
                (object) ['code' => 'export-excel', 'name' => 'Export Excel', 'description' => 'Export to excel feature']
            ],
            'history' => [
                (object) ['code' => 'history', 'name' => 'History Data', 'description' => 'View history data feature']
            ],
            'release' => [
                (object) ['code' => 'release', 'name' => 'Release', 'description' => 'Release data feature'],
                (object) ['code' => 'unrelease', 'name' => 'Unrelease', 'description' => 'Unrelease data feature'],
            ]
        ];

        $template = isset($templates[$templatekey]) ? $templates[$templatekey] : [];

        foreach ($template as $temp) {
            $checkFeature = $this->component->checkFeature($menuid, $temp->code);

            if (is_null($checkFeature))
                $this->component->store([
                    'menuid' => $menuid,
                    'componentcode' => $temp->code,
                    'componentname' => $temp->name,
                    'description' => $temp->description,
                    'createdby' => getSession('userid'),
                    'createddate' => date('Y-m-d H:i:s'),
                    'isactive' => true,
                ]);
        }

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }

    public function updateFieldFeatures()
    {
        $id = decrypting($this->getPost('id'));
        $column = $this->getPost('column');
        $value = $this->getPost('value');

        $updates[$column] = $value;
        $updates['updatedby'] = getSession('userid');
        $updates['updateddate'] = date('Y-m-d H:i:s');

        $this->component->edit($updates, $id);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully',
            ]);
    }
}
