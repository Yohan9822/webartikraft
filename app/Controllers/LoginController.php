<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Msaccessgroup;
use App\Models\Msuser;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    protected $user;
    protected $acg;
    public function __construct()
    {
        $this->user = new Msuser();
        $this->acg = new Msaccessgroup();
    }

    public function index()
    {
        return view('cms/auth/v_login');
    }

    public function authProcess()
    {
        $uname = trim($this->getPost('username'));
        $pass = trim($this->getPost('password'));

        if (empty($uname) || empty($pass)) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => 'Username and Password is required'
                ]);
        }

        $data = $this->user->authenticate($uname);

        if (is_null($data))
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => 'Username not found',
                ]);

        if (!password_verify($pass, rtrim($data->password)))
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => 'Invalid username or password',
                ]);

        if ($data->isactive != 't')
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => 'User is non active'
                ]);

        $userid = $data->userid;
        $session = $this->acg->getAccessGroup($userid);

        if (is_null($session))
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => 'Invalid user access'
                ]);

        if (empty($session->companyid))
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'sukses' => 0,
                    'pesan' => "You don't have company access"
                ]);

        setSession('userid', $data->userid);
        setSession('name', $data->name);
        setSession('groupid', $session->usergroupid);
        setSession('groupname', $session->groupname);
        setSession('companyid', $session->companyid);
        setSession('companyname', $session->companyname);
        setSession('usertype', $session->typename);
        setSession('usertypeid', $session->usertypeid);

        return $this->response->setStatusCode(200)
            ->setJSON([
                'sukses' => 1,
                'pesan' => 'Login Berhasil',
                'redirect' => getURL('cms/dashboard')
            ]);
    }

    public function logoutProcess()
    {
        destroySession();
        return redirect()->to(getURL('cms'));
    }
}
