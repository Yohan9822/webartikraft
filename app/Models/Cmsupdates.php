<?php

namespace App\Models;

use CodeIgniter\Model;

class Cmsupdates extends BaseModel
{
    protected $table = "cms.cmsupdates as up";
    protected $primaryKey = "id";

    public function setFindQuery()
    {
        return $this->builder->select([
            'up.*',
            'u.name as createdname',
            'uu.name as updatedname'
        ])->join('master.msuser as u', 'u.userid=up.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = up.updatedby', 'left');
    }

    public $searchDataTable = [
        null,
        null,
        'up.caption',
        null,
        null,
        null,
        null,
        null
    ];

    public function getDataTable()
    {
        return $this->builder
            ->select([
                'up.*',
                'u.name as createdname',
                'uu.name as updatedname'
            ])->join('master.msuser as u', 'u.userid=up.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = up.updatedby', 'left')
            ->orderBy('up.id', 'asc');
    }
}
