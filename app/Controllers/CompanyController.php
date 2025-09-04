<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CompanyController extends BaseController
{
    public function index()
    {
        return view('pages/v_company', [
            'title' => strtoupper(lang('Global.nav-company')) . ' | Arti Kraft Indonesia',
        ]);
    }
}
