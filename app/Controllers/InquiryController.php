<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InquiryController extends BaseController
{
    public function index()
    {
        return view('pages/v_inquiry', [
            'title' => 'Inquiry | Arti Kraft Indonesia',
        ]);
    }
}
