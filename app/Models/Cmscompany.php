<?php

namespace App\Models;

use CodeIgniter\Model;

class Cmscompany extends BaseModel
{
    protected $table = 'cms.cmscompany as cm';
    protected $primaryKey = "id";

    public function setFindQuery()
    {
        return $this->builder->select([
            'cm.*',
            'u.name as createdname',
            'uu.name as updatedname'
        ])->join('master.msuser as u', 'u.userid=cm.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = cm.updatedby', 'left');
    }
    public function getDefaultContent()
    {
        return $this->builder
            ->orderBy("id", "desc")
            ->limit(1)
            ->get()->getRowObject();
    }
}
