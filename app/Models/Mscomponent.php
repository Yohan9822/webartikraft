<?php

namespace App\Models;

use CodeIgniter\Model;

class Mscomponent extends BaseModel
{
    protected $table = "master.mscomponent as a";
    protected $primaryKey = "componentid";

    public $searchDataTables = [
        null,
        'a.componentcode',
        'a.componentname',
        'a.description',
        'a.isactive' => [
            'query' => 'booleanSearchQuery'
        ],
        null
    ];

    public function getDataTatables($menuid)
    {
        $query = $this->builder->where('a.menuid', $menuid);

        return $query;
    }

    public function checkFeature($menuid, $code)
    {
        return $this->builder->where('a.menuid', $menuid)
            ->where('a.componentcode', $code)
            ->get()->getFirstRow();
    }
}
