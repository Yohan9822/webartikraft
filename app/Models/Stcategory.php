<?php

namespace App\Models;

use CodeIgniter\Model;

class Stcategory extends BaseModel
{
    protected $table = "master.stcategory as c";
    protected $primaryKey = "catid";

    public $searchDataTable = [
        null,
        'c.catcode',
        'c.catname',
        'c.createddate',
        'u.name',
        'c.updateddate',
        'uu.name',
        null
    ];

    public function getDataTable()
    {
        return $this->builder
            ->select([
                'c.catid',
                'c.catcode',
                'c.catname',
                'c.createddate',
                'c.createdby',
                'c.updateddate',
                'c.updatedby',
                'u.name as createdname',
                'uu.name as updatedname'
            ])->join('master.msuser as u', 'u.userid=c.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = c.updatedby', 'left');
    }

    public function search($searchValue)
    {
        return $this->builder->select([
            'c.catid',
            'c.catname'
        ])->groupStart()
            ->like('trim(lower(c.catname))', "%$searchValue%")
            ->groupEnd()
            ->get()->getResultObject();
    }

    public function byCode($categorycode)
    {
        return $this->builder->select([
            'c.catid',
            'c.catname',
        ])->where('c.catcode', $categorycode)
            ->get()
            ->getFirstRow();
    }
}
