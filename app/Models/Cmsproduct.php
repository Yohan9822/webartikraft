<?php

namespace App\Models;

use CodeIgniter\Model;

class Cmsproduct extends BaseModel
{
    protected $table = "cms.cmsproducts as p";
    protected $primaryKey = "id";

    public function setFindQuery()
    {
        return $this->builder->select([
            'p.*',
            'u.name as createdname',
            'uu.name as updatedname',
            'ty.typecode',
            'ty.typename as categoryname',
            'tt.typecode as materialcode',
            'tt.typename as materialname'
        ])
            ->join('master.sttype as tt', 'tt.typecode=p.material', 'left')
            ->join('master.sttype as ty', 'ty.typecode=p.category', 'left')
            ->join('master.msuser as u', 'u.userid=p.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = p.updatedby', 'left');
    }

    public $searchDataTable = [
        null,
        null,
        'ty.typename',
        'p.productname',
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
                'p.*',
                'u.name as createdname',
                'uu.name as updatedname',
                'ty.typecode',
                'ty.typename as categoryname',
                'tt.typecode as materialcode',
                'tt.typename as materialname'
            ])
            ->join('master.sttype as tt', 'tt.typecode=p.material', 'left')
            ->join('master.sttype as ty', 'ty.typecode=p.category', 'left')
            ->join('master.msuser as u', 'u.userid=p.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = p.updatedby', 'left')
            ->orderBy('p.id', 'asc');
    }
}
