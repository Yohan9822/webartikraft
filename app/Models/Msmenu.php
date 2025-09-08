<?php

namespace App\Models;

use CodeIgniter\Model;

class Msmenu extends BaseModel
{
    protected $table = 'master.msmenu as a';
    protected $primaryKey = 'menuid';

    public function getOne($menuid)
    {
        $query = $this->builder->select([
            'a.menuid',
            'a.menuname',
            'master.menuname as mastername',
            'master.menuid as masterid',
            'a.menulink',
            'a.menuicon',
            'a.sequence'
        ])->join('master.msmenu master', 'master.menuid=a.masterid', 'left')
            ->where('a.menuid', $menuid);

        return $query->get()->getFirstRow();
    }

    public $searchDataTable = [
        null,
        'a.menuname',
        'parent.menuname',
        'a.menulink',
        'a.menuicon',
        null
    ];

    public function getDataTables($masterId = null)
    {
        $query = $this->builder->select([
            'a.menuid',
            'a.menuname',
            'parent.menuname as mastername',
            'parent.menuid as masterid',
            'a.menulink',
            'a.menuicon',
            'a.sequence'
        ])->join('master.msmenu as parent', 'parent.menuid = a.masterid', 'left');

        if (!is_null($masterId)) $query->where('a.masterid', $masterId);

        return $query;
    }

    public function getMaster($search = null)
    {
        return $this->builder->like('lower(a.menuname)', strtolower($search))
            ->get()->getResultObject();
    }

    public function updateJson($json)
    {
        return $this->db->query("
            UPDATE master.msmenu SET
                masterid = json_menu.headerid,
                sequence = json_menu.sequence
            FROM json_to_recordset('$json'::json) as json_menu(menuid int, headerid int, sequence int)
            WHERE msmenu.menuid = json_menu.menuid
        ");
    }

    public function getAccessGroup($groupid)
    {
        return $this->builder->select([
            'a.menuid',
            'COALESCE(a.masterid, 0) as masterid',
            'a.menuname',
            'a.menuicon',
            'a.menulink',
            'a.sequence',
            "JSON_AGG(
                JSON_BUILD_OBJECT(
                    'accessid', accmenu.id,
                    'componentid', comp.componentid,
                    'componentname', comp.componentname,
                    'componentcode', comp.componentcode,
                    'description', comp.description
                )
            ) as components"
        ])->join('master.mscomponent as comp', 'comp.menuid = a.menuid', 'left')
            ->join('master.msaccessmenu as accmenu', "accmenu.menuid = a.menuid 
                AND accmenu.componentid = comp.componentid 
                AND accmenu.usergroupid = $groupid", "left")
            ->groupBy([
                'a.menuid',
                'a.masterid',
                'a.menuname',
                'a.menuicon',
                'a.menulink',
                'a.sequence',
            ])
            ->get()
            ->getResultObject();
    }

    public function getByUrl($url)
    {
        return $this->builder->join('master.msaccessmenu as accmenu', 'accmenu.menuid = a.menuid', 'left')
            ->where('lower(menulink)', strtolower($url))
            ->orderBy('accmenu.id', 'desc')
            ->get()->getFirstRow();
    }
}
