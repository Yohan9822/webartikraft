<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function index()
    {
        return view('pages/v_product', [
            'title' => 'Products | Arti Kraft Indonesia',
        ]);
    }

    public function detailPage($id)
    {
        return view('pages/v_product_detail', [
            'title' => 'Products Detail | Arti Kraft Indonesia',
        ]);
    }
}
