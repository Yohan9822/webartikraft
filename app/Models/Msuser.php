<?php

namespace App\Models;

use CodeIgniter\Model;

class Msuser extends BaseModel
{
    protected $table = 'master.msuser as m';
    protected $primaryKey = 'userid';

    public function authenticate($username)
    {
        return $this->builder->where('m.username', $username)
            ->get()->getFirstRow();
    }

    public $searchDataTable = [
        null,
        'm.name',
        'm.username',
        null,
    ];

    public function getDataTable()
    {
        return $this->builder->select([
            'm.userid',
            'm.name',
            'm.username',
            'm.createddate',
            'created.name as createdname',
            'm.updateddate',
            'updated.name as updatedname',
            'm.isactive',
        ])->join('master.msuser as created', 'created.userid = m.createdby', 'left')
            ->join('master.msuser as updated', 'updated.userid = m.updatedby', 'left')
            ->orderBy('m.userid', 'asc');
    }
}
