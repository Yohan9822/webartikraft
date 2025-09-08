<?php

namespace App\Helpers\Privileges;

use App\Models\Msaccessmenu;
use App\Models\Msmenu;

class PrivilegesUser
{

    static public $instance;

    public static function instance($menuid = null)
    {
        if (is_null(self::$instance)) {
            self::$instance = (new PrivilegesUser($menuid))->fetch();
        }

        return self::$instance;
    }

    public static function setRoute($route)
    {
        $instance = PrivilegesUser::instance();

        $row = (new Msmenu)->getByUrl($route);

        if (is_null($row))
            throw new \Exception("Invalid route menu");

        $instance->menuid = $row->menuid;
        $instance->menuname = $row->menuname;

        return $instance;
    }

    public $userid;

    public $companyid;

    public $menuid;

    public $menuname;

    protected $accesses = [];

    public function __construct($menuid = null)
    {
        $this->userid = session()->get('userid');
        $this->companyid = session()->get('companyid');
        $this->menuid = $menuid ?? session()->get('menuid');
    }

    public function getMenus()
    {
        return $this->accesses;
    }

    public function getMenuId()
    {
        return $this->menuid;
    }

    public function fetch()
    {
        $this->accesses = (new Msaccessmenu)->getByGroup(getSession('groupid'));

        return $this;
    }

    public function resetRoute()
    {
        $this->menuid = session()->get('menuid');
    }

    public function has($code)
    {
        if (empty($this->menuid))
            throw new \Exception("Page Not Found", 404);

        if (!is_array($code)) $code = [$code];

        $isValid = false;
        foreach ($this->accesses as $access) {
            if ($access->menuid != $this->menuid) continue;

            if (in_array($access->componentcode, $code)) {
                $isValid = true;
                break;
            }
        }

        return $isValid;
    }

    public function name()
    {
        return $this->menuname;
    }
}
