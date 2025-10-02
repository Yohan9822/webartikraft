<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CmsBamboo;
use CodeIgniter\HTTP\ResponseInterface;

class BambooController extends BaseController
{
    public function index()
    {
        $row = (new CmsBamboo())->getDefaultContent();
        return view('pages/v_bamboo', [
            'title' => strtoupper(lang('Global.nav-bamboo')) . ' | Arti Kraft Indonesia',
            'row' => $row
        ]);
    }
}
