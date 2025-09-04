<?php

namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/v_home', [
            'title' => strtoupper(lang('Global.nav-home')) . ' | Arti Kraft Indonesia',
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
}
