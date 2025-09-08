<?php

namespace App\Controllers;

use App\Libraries\Config\BlueStickerConfig;
use CodeIgniter\Files\File;

class PreviewFile extends BaseController
{

    public function __construct() {}

    public function download()
    {

        $filename = $this->getPost('file_name');
        $mimeType = $this->getPost('mime_type');
        $urlPreview = $this->getPost('url_preview');

        $html = '';
        if (in_array($mimeType, ['application/pdf'])) {
            $html = "<div class=\"dflex justify-center align-center flex-column\">
                <div class=\"dflex align-center flex-column margin-b\" style=\"width: 250px\">
                    <i class=\"bx bxs-file-archive bx-lg text-dark\"></i>
                    <span class=\"text-center fs-7\" style=\"width: 100%;overflow-wrap: anywhere;\">$filename</span>
                </div>
                <a href=\"$urlPreview\" class=\"fs-7 text-link margin-b-1\" download>
                    <span>Download PDF</span>
                </a>
            <div>";
        } else {
            $html = "<div class=\"dflex\">
                <img src=\"$urlPreview\" width=\"100%\" />
                <a href=\"$urlPreview\" class=\"fs-7 text-link margin-b-1\" download>
                    <span>Download File</span>
                </a>
            <div>";
        }

        // if (["zip", "7z", "rar"] . includes(product . file . extension)) {
        //     return `<div class="h-[80px] w-[80px] flex flex-col justify-center items-center">
        //                   <i class="bx bxs-file-archive bx-lg"></i>
        //                   <span class="text-sm">.${product . file . extension}</span>
        //               </div>`;
        // } else if (["pdf"] . includes(product . file . extension)) {
        //     return `<div class="h-[80px] w-[80px] flex flex-col justify-center items-center">
        //                   <i class="bx bxs-file-pdf bx-lg"></i>
        //                   <span class="text-sm">.${product . file . extension}</span>
        //               </div>`;
        // } else {
        //     return `<div class="h-[80px] w-[80px] flex flex-col justify-center items-center">
        //                   <i class="bx bxs-file-blank bx-lg"></i>
        //                   <span class="text-sm">.${product . file . extension}</span>
        //               </div>`;
        // }

        $json['view'] = $html;

        return $this->response->setJSON($json);
    }

    public function image($doctype, $directory, $filename)
    {
        $directory = preg_replace(
            [
                '/-/'
            ],
            [
                '/'
            ],
            $directory
        );


        $realPath = WRITEPATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $filename;
        $file = new File($realPath);
        $filename = $file->getFilename();

        if (!file_exists($realPath)) {
            $realPath = FCPATH . 'public/icon-wo.png';
            $file = new File($realPath);
            $filename = 'icon-wo.png';
        }
        $binary = readfile($realPath);

        return $this->response
            ->setHeader('Content-Type', $file->getMimeType())
            ->setHeader('Content-disposition', 'inline; filename="' . $filename . '"')
            ->setStatusCode(200)
            ->setBody($binary);
    }
}
