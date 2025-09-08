<?php

namespace App\Controllers\Cms;

use AccessCode;
use App\Controllers\BaseController;
use App\Helpers\FileJsonObject;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Datatables\Datatables;
use App\Models\CmsSlides;
use App\Models\Sttype;
use ButtonComponents;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use FormComponents;

class SlideImage extends BaseController
{
    protected $slides;
    protected $type;

    protected $breadcrumb = [
        'Cms',
        'Slide Image'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/slide');
        $this->type = new Sttype();
        $this->slides = new CmsSlides();
    }

    public function index()
    {
        $data['title'] = 'Slide Image | Cms';
        $data['section'] = 'Slide Image';
        $data['breadcrumb'] = $this->breadcrumb;

        return view('cms/slides/v_slide', $data);
    }

    public function datatable()
    {
        $datatables = Datatables::method([CmsSlides::class, 'getDataTable'], 'searchDataTable')
            ->make();

        $datatables->updateRow(function ($db, $no) {
            $encryptId = encrypting($db->id);

            $btnEdit = ButtonComponents::editModalDataTable(
                "Update Slide Image",
                getURL("cms/slide/form/$encryptId"),
                ['modalSize' => 'modal-lg']
            );

            $btnDelete = ButtonComponents::deleteModalDataTable(
                "Delete Slide Image",
                getURL('cms/slide/delete'),
                ['id' => $encryptId]
            );

            $cellIsActive = FormComponents::builder(
                'slide-image',
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
                "<div class='text-center'>$db->captionposition</div>",
                "<div class='text-center'>$db->slideseq</div>",
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
        $data['title'] = 'Slide Image | CMS';
        $data['section'] = 'Slide Image';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['category'] = $category;

        if (!empty($id)) {
            $row = $this->slides->find(decrypting($id));
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

        $json['view'] = view('cms/slides/v_form', $data);

        return response()->setJSON($json);
    }

    public function add()
    {
        $file = $this->getFile('image');
        $caption = $this->getPost('caption');
        $position = $this->getPost('position');
        $sequence = $this->getPost('sequence');

        $this->db->transBegin();
        try {
            $payload = (object) [];

            if (is_null($file)) throw new Exception("Images required for slide");
            if (!empty($caption) && empty($position)) throw new Exception("You need to select a caption position!");
            if (!is_null($file) && !$file->isValid())
                throw new \Exception("Invalid image");

            if (!is_null($file) && $file->isValid()) {
                $fileJson = new FileJsonObject();
                $fileJson->move($file, "uploads/slides");
                $payload->logo = $fileJson->files();
            }

            $slideseq = null;
            if (!empty($sequence)) {
                $slideseq = $sequence;
            } else {
                $rowSeq = $this->slides->getLastSequence();
                if (empty($rowSeq)):
                    $slideseq = 1;
                else:
                    $slideseq = $rowSeq->slideseq + 1;
                endif;
            }

            $insert = [
                'caption' => $caption,
                'payload' => json_encode($payload),
                'slideseq' => $slideseq,
                'isactive' => true,
                'captiontype' => $position,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => getSession('userid')
            ];

            $this->slides->store($insert);

            $this->db->transCommit();
            return $this->response->setJSON([
                'sukses' => 1,
                'pesan' => 'Successfully'
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
        $position = $this->getPost('position');
        $sequence = $this->getPost('sequence');

        $this->db->transBegin();
        try {
            if (is_null($fileValue)) throw new Exception("Images required for slide");
            if (!empty($caption) && empty($position)) throw new Exception("You need to select a caption position!");
            if (!is_null($file) && !$file->isValid())
                throw new \Exception("Invalid image");

            $row = $this->slides->find($id);

            $slideseq = null;
            if (!empty($sequence)) {
                $slideseq = $sequence;
            } else {
                $rowSeq = $this->slides->getLastSequence();
                if (empty($rowSeq)):
                    $slideseq = 1;
                else:
                    $slideseq = $rowSeq->slideseq + 1;
                endif;
            }

            $payload = json_decode($row->payload ?? '{}');
            $editFileJson = new FileJsonObject($payload->logo ?? []);

            if (!is_null($file) && $file->isValid()) {
                $fileJson = new FileJsonObject();
                $fileJson->move($file, "uploads/slides");
                $payload->logo = $fileJson->files();

                $editFileJson->removeAll();
            } else if (is_null($file) && empty($fileValue)) {
                $editFileJson->removeAll();

                $payload->logo = $editFileJson->files();
            }

            $update = [
                'caption' => $caption,
                'payload' => json_encode($payload),
                'slideseq' => $slideseq,
                'captiontype' => $position,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid')
            ];

            $this->slides->edit($update, $id);

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

        $this->slides->destroy($id);

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

        $this->slides->edit($updates, $id);

        return $this->response->setJSON([
            'sukses' => 1,
            'pesan' => 'Sucessfully'
        ]);
    }
}
