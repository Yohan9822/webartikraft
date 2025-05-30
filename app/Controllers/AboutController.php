<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AboutController extends BaseController
{
    public function index()
    {
        return view('pages/v_about', [
            'title' => 'About | Arti Kraft Indonesia',
        ]);
    }
}
