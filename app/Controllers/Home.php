<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/v_home', [
            'title' => 'Home | Arti Kraft Indonesia',
        ]);
    }
}
