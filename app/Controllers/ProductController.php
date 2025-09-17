<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function index()
    {
        $dataProduct = getProducts();
        return view('pages/v_product', [
            'title' => strtoupper(lang('Global.nav-furnishing')) . ' | Arti Kraft Indonesia',
            'products' => $dataProduct,
        ]);
    }
}
