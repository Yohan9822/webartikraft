<?php

namespace App\Controllers\Cms;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\FileJsonObject;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\Cmsupdates;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use FormComponents;

class TheUpdates extends BaseController
{
    protected $updates;

    protected $breadcrumb = [
        'Cms',
        'The Updates'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/the-updates');
        $this->updates = new Cmsupdates();
    }

    public function index()
    {
        $data['title'] = 'The Updates | Cms';
        $data['section'] = 'The Updates';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/updates/v_updates', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([Cmsupdates::class, 'getDataTable'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->id);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Product",
                getURL("cms/the-updates/form/$encryptId"),
                ['modalSize' => 'modal-lg']
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Product",
                getURL('cms/the-updates/delete'),
                ['id' => $encryptId]
            );

            $cellIsActive = FormComponents::builder(
                'update-image',
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
                $db->caption,
                "<div class='text-center'>" . formatBytes($db->payload->size ?? 0) . "</div>",
                date('m d Y', strtotime($db->date)),
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
        $data['title'] = 'The Updates | CMS';
        $data['section'] = 'The Updates';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['category'] = $category;

        if (!empty($id)) {
            $row = $this->updates->find(decrypting($id));
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

        $json['view'] = view('cms/updates/v_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        $file = $this->getFile('image');
        $caption = $this->getPost('caption');
        $dateInput = $this->getPost('update');

        $this->db->transBegin();
        try {
            $payload = (object) [];

            if (empty($caption)) throw new Exception("Caption is required!");
            if (empty($dateInput)) throw new Exception("Date is required!");
            if (is_null($file)) throw new Exception("Images required for product");
            if (!is_null($file) && !$file->isValid())
                throw new \Exception("Invalid image");

            if (!is_null($file) && $file->isValid()) {
                $fileSize = $file->getSize();

                $fileJson = new FileJsonObject();
                $fileJson->move($file, "uploads/updates");

                $payload->logo = $fileJson->files();
                $payload->size = $fileSize;
            }

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $dateInput)));

            $insert = [
                'payload'     => json_encode($payload),
                'caption'     => $caption,
                'date'        => $date,
                'isactive'    => true,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby'   => getSession('userid')
            ];

            $this->updates->store($insert);

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
        $caption = $this->getPost('caption');
        $dateInput = $this->getPost('update');

        $this->db->transBegin();
        try {
            if (empty($caption)) throw new Exception("Caption is required!");
            if (empty($dateInput)) throw new Exception("Date is required!");
            if (is_null($fileValue)) throw new Exception("Images required for product");
            if (!is_null($file) && !$file->isValid())
                throw new \Exception("Invalid image");

            $row = $this->updates->find($id);

            $payload = json_decode($row->payload ?? '{}');
            $editFileJson = new FileJsonObject($payload->logo ?? []);

            if (!is_null($file) && $file->isValid()) {
                $fileSize = $file->getSize();

                $fileJson = new FileJsonObject();
                $fileJson->move($file, "uploads/updates");

                $payload->logo = $fileJson->files();
                $payload->size = $fileSize;

                $maxRetries = 3;
                for ($i = 0; $i < $maxRetries; $i++) {
                    try {
                        $editFileJson->removeAll();
                        break;
                    } catch (\Exception $e) {
                        if ($i < $maxRetries - 1) {
                            usleep(50000);
                        } else {
                            throw $e;
                        }
                    }
                }
            } else if (is_null($file) && empty($fileValue)) {
                $maxRetries = 3;
                for ($i = 0; $i < $maxRetries; $i++) {
                    try {
                        $editFileJson->removeAll();
                        break;
                    } catch (\Exception $e) {
                        if ($i < $maxRetries - 1) {
                            usleep(50000);
                        } else {
                            throw $e;
                        }
                    }
                }

                $payload->logo = $editFileJson->files();
                unset($payload->size);
            }

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $dateInput)));

            $update = [
                'payload'     => json_encode($payload),
                'caption'     => $caption,
                'date'        => $date,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid')
            ];

            $this->updates->edit($update, $id);

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

        $this->updates->destroy($id);

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

        $this->updates->edit($updates, $id);

        return $this->response->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }
}
