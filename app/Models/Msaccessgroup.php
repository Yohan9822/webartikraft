<?php

namespace App\Models;

use AccessCode;
use CodeIgniter\Model;

class Msaccessgroup extends BaseModel
{
    protected $table = 'master.msaccessgroup as a';
    protected $primaryKey = 'accessgroupid';

    public function getAccessGroup($userid)
    {
        return $this->builder->select([
            'usr.userid',
            'a.usergroupid',
            'usrgroup.groupname',
            'a.usertypeid',
            'a.companyid',
            'comp.companyname',
            'usrtype.typename',
        ])->join('master.mscompany as comp', 'comp.companyid = a.companyid and comp.isactive = true', '', false)
            ->join('master.sttype as usrtype', 'usrtype.typeid = a.usertypeid and usrtype.isactive = true', '', false)
            ->join('master.msusergroup as usrgroup', 'usrgroup.groupid = a.usergroupid and usrgroup.isactive = true', '', false)
            ->join('master.msuser as usr', 'usr.userid = a.userid')
            ->where('a.userid', $userid)
            ->get()->getFirstRow();
    }

    public $searchDataTable = [
        null,
        "b.groupname",
        "tp.typename",
        null,
        "cm.companyname",
        "a.isdefault",
    ];

    public function getDataTable($userid)
    {
        return $this->builder
            ->select("a.accessgroupid, b.groupname, json_agg(json_build_object('menuname', d.menuname) order by d.masterid) as list_menu, a.usertypeid, a.isdefault, cm.companyname, a.userid, tp.typename")
            ->join('master.msusergroup as b', 'b.groupid=a.usergroupid')
            ->join('master.msaccessmenu as c', 'c.usergroupid=a.usergroupid', 'left')
            ->join('master.mscomponent as com', 'com.componentid = c.componentid', 'left')
            ->join('master.msmenu as d', 'd.menuid=c.menuid', 'left')
            ->join('master.mscompany cm', 'cm.companyid=a.companyid', 'left')
            ->join('master.sttype as tp', 'tp.typeid = a.usertypeid', 'left')
            ->where('a.userid', $userid)
            ->where('com.componentcode', AccessCode::view)
            ->groupBy('b.groupname, tp.typename, cm.companyname, a.accessgroupid');
    }

    function checkIsDefault($userid)
    {
        return $this->builder->select('mscompany.companyid, mscompany.companyname, a.isdefault')
            ->join('master.mscompany', 'mscompany.companyid=a.companyid')
            ->where('userid', $userid)
            ->orderBy('isdefault', 'desc')
            ->get()->getFirstRow();
    }

    public function checkAccessgroup($userid, $usergroupid, $companyid)
    {
        return $this->builder->where('userid', $userid)
            ->where('usergroupid', $usergroupid)
            ->where('companyid', $companyid)
            ->get()->getFirstRow();
    }
}
