<?php

namespace App\Controllers;

use App\Models\Cmsupdates;
use Config\Services;

class Home extends BaseController
{
    protected $updates;

    public function __construct()
    {
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
}
