<?php

namespace App\Models;

use CodeIgniter\Model;

class Msaccessmenu extends BaseModel
{
    protected $table = "master.msaccessmenu as accmenu";
    protected $primaryKey = 'id';

    public function getByGroup($groupId)
    {
        return $this->builder->select([
            'menu.menuid',
            'menu.masterid',
            'menu.menuname',
            'menu.menulink',
            'menu.menuicon',
            'menu.sequence',
            'com.componentcode'
        ])->join('master.msmenu as menu', 'menu.menuid = accmenu.menuid and menu.isactive = true', '', false)
            ->join('master.mscomponent as com', 'com.menuid = accmenu.menuid 
                and com.componentid = accmenu.componentid 
                and com.isactive = true', '', false)
            ->where('accmenu.usergroupid', $groupId)
            ->get()->getResultObject();
    }

    public function deleteByParam($param, $value)
    {
        return $this->builder->delete([$param => $value]);
    }
}
