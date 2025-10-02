<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsBamboo extends BaseModel
{
    protected $table            = 'cms.cmsbamboo';
    protected $primaryKey       = 'id';

    public function searchable()
    {
        return [
            null,
            "cmsbamboo.content",
            null,
            null
        ];
    }

    public function setFindQuery()
    {
        return $this->builder
            ->select("cmsbamboo.*, us.name as creator")
            ->join("msuser as us", "us.userid=cmsbamboo.createdby", "left");
    }

    public function getDatatable()
    {
        return $this->builder
            ->select("cmsbamboo.*, us.name as creator")
            ->join("msuser as us", "us.userid=cmsbamboo.createdby", "left");
    }

    public function getDefaultContent()
    {
        return $this->builder
            ->orderBy("id", "desc")
            ->limit(1)
            ->get()->getRowObject();
    }
}
