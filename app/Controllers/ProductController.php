<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cmsproduct;
use App\Models\Cmsproductcategory;
use App\Models\Stcategory;
use App\Models\Sttype;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected $category;
    protected $product;
    protected $types;

    public function __construct()
    {
        $this->category = new Cmsproductcategory();
        $this->product = new Cmsproduct();
        $this->types = new Sttype();
    }

    public function index()
    {
        $dataProduct = getProducts();
        $category = $this->types->getByCatCode('product-category');

        return view('pages/v_product', [
            'title' => strtoupper(lang('Global.nav-furnishing')) . ' | Arti Kraft Indonesia',
            'products' => $dataProduct,
            'categories' => $category,
        ]);
    }

    public function getProducts()
    {
        $search = strtolower($this->getPost('search'));
        $category = strtolower($this->getPost('category'));

        $dataProduct = getProducts($search, $category);

        return $this->response->setJSON([
            'sukses' => 1,
            'data' => $dataProduct
        ]);
    }

    public function detailProduct($productid)
    {
        $productid = decrypting($productid);

        $row = $this->product->find($productid);

        $row->payload = json_decode($row->payload ?? '{}');

        if (!empty($row->payload->logo))
            $row->payload->logo = files_preview($row->payload->logo);

        return view('pages/v_detail', [
            'title' => 'Detail Product - ' . $row->productname,
            'row' => $row,
        ]);
    }
}
