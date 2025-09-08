<?php

namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
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
            session()->set('locale', $lang);
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
}
