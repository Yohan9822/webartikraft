<?php

namespace App\Models;

use CodeIgniter\Model;

class Cmsfullcontent extends BaseModel
{
    protected $table = 'cms.cmsfullcontent as ct';
    protected $primaryKey = "id";

    public function setFindQuery()
    {
        return $this->builder->select([
            'ct.*',
            'u.name as createdname',
            'uu.name as updatedname'
        ])->join('master.msuser as u', 'u.userid=ct.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = ct.updatedby', 'left');
    }

    public function getAllContent($lang)
    {
        return $this->builder
            ->where("ct.lang", $lang)
            ->get()->getResultObject();
    }

    public function getByKey($lang, $key)
    {
        return $this->builder
            ->where("ct.lang", $lang)
            ->where("lower(ct.key)", strtolower($key))
            ->get()->getRowObject();
    }
}
