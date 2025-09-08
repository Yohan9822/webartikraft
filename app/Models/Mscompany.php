<?php

namespace App\Models;

use CodeIgniter\Model;

class Mscompany extends BaseModel
{
    protected $table = "master.mscompany as a";
    protected $primaryKey = "companyid";

    public function search($searchKey)
    {
        return $this->builder->select([
            'a.companyid',
            'a.companyname'
        ])->groupStart()
            ->like('trim(lower(a.companyname))', "%$searchKey%")
            ->groupEnd()
            ->get()->getResultObject();
    }

    public $searchDataTable = [
        null,
        'a.companyname',
        'a.address',
        'us.name',
        'a.createddate' => [
            'query' => 'dateSearchQuery'
        ],
        'uss.name',
        'a.updateddate' => [
            'query' => 'dateSearchQuery',
        ],
        null,
    ];

    public function getDataTable()
    {
        return $this->builder->select([
            'a.companyid',
            'a.companyname',
            'a.address',
            'a.createddate',
            'a.updateddate',
            'us.name as createdby',
            'uss.name as updatedby'
        ])->join('master.msuser us', 'us.userid=a.createdby', 'left')
            ->join('master.msuser uss', 'uss.userid=a.updatedby', 'left')
            ->orderBy("a.companyid", "asc");
    }
}
