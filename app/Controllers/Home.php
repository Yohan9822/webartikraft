<?php

namespace App\Controllers;

use App\Helpers\FileJsonObject;
use App\Models\Cmsfullcontent;
use App\Models\Cmsupdates;
use Config\Services;
use Exception;

class Home extends BaseController
{
    protected $updates;
    protected $fullcontent;

    public function __construct()
    {
        $this->fullcontent = new Cmsfullcontent();
        $this->updates = new Cmsupdates();
    }

    public function index()
    {
        $dataSlide = getSlideImage();
        $dataProduct = getProducts();
        $dataUpdates = getUpdates();

        return view('pages/v_home', [
            'title' => strtoupper(lang('Global.nav-home')) . ' | Arti Kraft Indonesia',
            'slides' => $dataSlide,
            'products' => $dataProduct,
            'updates' => $dataUpdates
        ]);
    }

    public function setLanguageWeb()
    {
        $lang = $this->request->getGet('lang');

        if (in_array($lang, ['en', 'id'])) {
            setSession('locale', $lang);
            service('request')->setLocale($lang);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    public function dashboardCms()
    {
        return view('cms/v_home_cms', [
            'section' => 'CMS Web-Artikraft',
            'title' => 'CMS -- ARTIKRAFT INDONESIA'
        ]);
    }

    public function updatesPage()
    {
        $dataUpdates = getUpdates();

        return view('pages/v_updates', [
            'title' => strtoupper(lang('Global.nav-updates')) . ' | Arti Kraft Indonesia',
            'updates' => $dataUpdates
        ]);
    }

    public function updateDetail($id)
    {
        $id = decrypting($id);

        $row = $this->updates->getDataTable()->where('up.id', $id)->get()->getRowObject();

        $row->payload = json_decode($row->payload ?? '{}');

        if (!empty($row->payload->logo))
            $row->payload->logo = files_preview($row->payload->logo);

        return view('pages/v_detailupdate', [
            'row' => $row,
            'cover' => $row->payload->logo,
            'title' => strtoupper(lang('Global.nav-updates')) . ' | Arti Kraft Indonesia',
            'id' => $id
        ]);
    }

    public function UpdateContent()
    {
        $lang = getSession('cms_lang');
        $key = $this->getPost('key');
        $keyMenu = $this->getPost('menu');
        $content = $this->getPost('content');

        $this->db->transBegin();
        try {
            if (empty($content))
                throw new Exception("$key Content must be filled!");

            $getRow = $this->fullcontent->getByKey($lang, $key);

            $this->fullcontent->edit([
                'key' => $key,
                'content' => $content,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => getSession('userid')
            ], $getRow->id);

            $data['content'] = getLangArray($lang);
            $data['lang'] = $lang;

            $view = view('cms/contentcompany/contentcompany', $data);
            if ($keyMenu == 'furnishing') $view = view('cms/contentfurnishing/contentfurnishing', $data);
            if ($keyMenu == 'bamboo') $view = view('cms/contentbamboo/contentbamboo', $data);

            $this->db->transCommit();
            return $this->response->setJSON([
                'success' => 1,
                'view' => $view,
                'pesan' => 'Content updated!',
                'dbError' => db_connect()->error()
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => 0,
                'pesan' => $e->getMessage(),
                'traceString' => $e->getTraceAsString()
            ]);
        }
    }

    public function updateImageContent()
    {
        $this->db->transBegin();
        try {
            $key  = $this->getPost('key');
            $keyMenu = $this->getPost('menu');
            $lang = getSession('cms_lang');
            $file = $this->getFile('file');

            if (is_null($file))
                throw new \Exception("Image file is required");

            if (!$file->isValid())
                throw new \Exception("Invalid image file");

            $payload = (object) [];
            $fileSize = $file->getSize();

            $fileJson = new FileJsonObject();
            $fileJson->move($file, 'uploads/content');
            $payload->image = $fileJson->files();
            $payload->size  = $fileSize;

            $filePath = base_url('uploads/content/' . $file->getName());

            $checkRow = $this->fullcontent->getByKey($lang, $key);

            if (empty($checkRow)) {
                $langs = ['id', 'en'];
                foreach ($langs as $ls) {
                    $this->fullcontent->store([
                        'content' => 'image',
                        'key' => $key,
                        'lang' => $ls,
                        'payload' => json_encode($payload),
                        'createddate' => date('Y-m-d H:i:s'),
                        'createdby' => getSession('userid')
                    ]);
                }
            } else {
                $this->fullcontent->edit([
                    'key' => $key,
                    'lang' => $lang,
                    'payload' => json_encode($payload),
                    'updateddate' => date('Y-m-d H:i:s'),
                    'updatedby' => getSession('userid')
                ], $checkRow->id);
            }

            $data['content'] = getLangArray($lang);
            $data['lang'] = $lang;

            $view = view('cms/contentcompany/contentcompany', $data);
            if ($keyMenu == 'furnishing') $view = view('cms/contentfurnishing/contentfurnishing', $data);
            if ($keyMenu == 'bamboo') $view = view('cms/contentbamboo/contentbamboo', $data);

            $this->db->transCommit();
            return $this->response->setJSON([
                'success' => 1,
                'view' => $view,
                'url' => $filePath,
                'dbError' => db_connect()->error()
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => 0,
                'pesan' => $e->getMessage(),
                'traceString' => $e->getTraceAsString()
            ]);
        }
    }

    public function switchLanguage()
    {
        $lang = $this->getPost('lang');
        $keyMenu = $this->getPost('menu');
        setSession('cms_lang', $lang);

        $data['lang'] = $lang;
        $data['content'] = getLangArray($lang);

        $view = view('cms/contentcompany/contentcompany', $data);
        if ($keyMenu == 'furnishing') $view = view('cms/contentfurnishing/contentfurnishing', $data);
        if ($keyMenu == 'bamboo') $view = view('cms/contentbamboo/contentbamboo', $data);

        return $this->response->setJSON([
            'success' => true,
            'view' => $view
        ]);
    }
}
