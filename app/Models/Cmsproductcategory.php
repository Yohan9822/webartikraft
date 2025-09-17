<?php

namespace App\Models;

use CodeIgniter\Model;

class Cmsproductcategory extends BaseModel
{
    protected $table = "cms.cmscategoryproduct as cc";
    protected $primaryKey = "id";

    public function setFindQuery()
    {
        return $this->builder->select([
            'cc.*',
            'u.name as createdname',
            'uu.name as updatedname'
        ])->join('master.msuser as u', 'u.userid=cc.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = cc.updatedby', 'left');
    }

    public $searchDataTable = [
        null,
        'cc.categoryname',
        null,
        null,
        null,
        null
    ];

    public function getDataTable()
    {
        return $this->builder
            ->select([
                'cc.*',
                'u.name as createdname',
                'uu.name as updatedname'
            ])->join('master.msuser as u', 'u.userid=cc.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = cc.updatedby', 'left')
            ->orderBy('cc.id', 'asc');
    }
}
