<?php

namespace App\Models;

use CodeIgniter\Model;

class Msusergroup extends BaseModel
{
    protected $table = 'master.msusergroup as a';
    protected $primaryKey = 'groupid';

    public $searchable = [
        null,
        'a.groupname',
        'u.name',
        'a.createddate' => [
            'query' => 'dateSearchQuery'
        ],
        'uu.name',
        'a.updateddate' => [
            'query' => 'dateSearchQuery'
        ],
        null
    ];

    public function getTable()
    {
        return $this->builder->select([
            'a.groupname',
            'a.groupid',
            'a.createddate',
            'a.updateddate',
            'u.name as createdby',
            'uu.name as updatedby'
        ])->join('master.msuser u', 'u.userid = a.createdby', 'left')
            ->join('master.msuser uu', 'uu.userid = a.updatedby', 'left')
            ->orderBy('a.groupid', 'asc');
    }

    public function search($searchKey)
    {
        return $this->builder->select([
            'a.groupid',
            'a.groupname'
        ])->groupStart()
            ->like('trim(lower(groupname))', "%$searchKey%")
            ->groupEnd()
            ->get()->getResultObject();
    }
}
