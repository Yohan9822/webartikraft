<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BambooController extends BaseController
{
    public function index()
    {
        return view('pages/v_bamboo', [
            'title' => strtoupper(lang('Global.nav-bamboo')) . ' | Arti Kraft Indonesia',
        ]);
    }
}
