<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cmscompany;
use CodeIgniter\HTTP\ResponseInterface;

class CompanyController extends BaseController
{
    protected $company;

    public function __construct()
    {
        $this->company = new Cmscompany();
    }

    public function index()
    {
        $dataUpdates = getUpdates();
        $row = $this->company->getDefaultContent();
        return view('pages/v_company', [
            'title' => strtoupper(lang('Global.nav-company')) . ' | Arti Kraft Indonesia',
            'slides' => getSlideImage(),
            'row' => $row,
            'updates' => $dataUpdates
        ]);
    }
}
