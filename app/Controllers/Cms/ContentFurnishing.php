<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use App\Helpers\Privileges\PrivilegesUser;
use App\Models\Cmsfullcontent;
use CodeIgniter\HTTP\ResponseInterface;

class ContentFurnishing extends BaseController
{

    protected $content;

    protected $breadcrumb = [
        'Cms',
        'Content Company'
    ];

    public function __construct()
    {
        PrivilegesUser::setRoute('cms/contentfurnishing');
        $this->content = new Cmsfullcontent();
    }

    public function index()
    {
        $data['title'] = 'Content Furnishing | Cms';
        $data['section'] = 'Content Furnishing';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['lang'] = getSession('cms_lang');
        $data['content'] = getLangArray($data['lang']);

        return view('cms/contentfurnishing/v_furnish', $data);
    }
}
