<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsSlides extends BaseModel
{
    protected $table = "cms.cmsslides as s";
    protected $primaryKey = "id";

    public function setFindQuery()
    {
        return $this->builder->select([
            's.id',
            's.caption',
            's.slideseq',
            's.isactive',
            's.payload',
            's.slidetype',
            's.createddate',
            's.createdby',
            's.updateddate',
            's.updatedby',
            'u.name as createdname',
            'uu.name as updatedname',
            'ty.typecode',
            'ty.typename as captionposition'
        ])->join('master.sttype as ty', 'ty.typecode=s.captiontype', 'left')
            ->join('master.msuser as u', 'u.userid=s.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = s.updatedby', 'left');
    }

    public $searchDataTable = [
        null,
        null,
        's.caption',
        null,
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
                's.id',
                's.caption',
                's.slideseq',
                's.slidetype',
                's.isactive',
                's.payload',
                's.captiontype',
                's.createddate',
                's.createdby',
                's.updateddate',
                's.updatedby',
                'u.name as createdname',
                'uu.name as updatedname',
                'ty.typecode',
                'ty.typename as captionposition'
            ])->join('master.sttype as ty', 'ty.typecode=s.captiontype', 'left')
            ->join('master.msuser as u', 'u.userid=s.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = s.updatedby', 'left')
            ->orderBy('s.slideseq', 'asc');
    }

    public function search($searchValue)
    {
        return $this->builder->select([
            's.id',
            's.caption'
        ])->groupStart()
            ->like('trim(lower(s.caption))', "%$searchValue%")
            ->groupEnd()
            ->get()->getResultObject();
    }

    public function getLastSequence()
    {
        return $this->builder
            ->where("s.isactive is true")
            ->orderBy("s.slideseq", "desc")
            ->limit(1)
            ->get()->getRowObject();
    }
}
