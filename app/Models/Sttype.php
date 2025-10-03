<?php

namespace App\Models;

use CodeIgniter\Model;

class Sttype extends BaseModel
{
    protected $table = "master.sttype as tp";
    protected $primaryKey = "typeid";

    public function setFindQuery()
    {
        return $this->builder->select([
            'tp.typeid',
            'tp.typecode',
            'tp.typename',
            'tp.payload',
            'c.catid',
            'c.catname',
        ])->join('master.stcategory c', 'c.catid = tp.catid');
    }

    public $searchDataTable = [
        null,
        'tp.typecode',
        'tp.typename',
        'c.catname',
        'tp.createddate' => [
            'query' => 'dateSearchQuery'
        ],
        'u.name',
        'tp.updateddate' => [
            'query' => 'dateSearchQuery',
        ],
        'uu.name',
        null
    ];

    public function getDataTable($filter = null)
    {
        $query = $this->builder->select([
            'tp.typeid',
            'tp.typecode',
            'tp.typename',
            'tp.catid',
            'tp.createddate',
            'tp.updateddate',
            'tp.createdby',
            'u.userid',
            'u.name as createdname',
            'uu.name as updatedname',
            'c.catid',
            'c.catname'
        ])->join('master.msuser as u', 'u.userid=tp.createdby', 'left')
            ->join('master.msuser as uu', 'uu.userid = tp.updatedby', 'left')
            ->join('master.stcategory as c', 'c.catid=tp.catid');

        if (!empty($filter->categoryid))
            $query->where('tp.catid', decrypting($filter->categoryid));

        return $query;
    }

    public function searchByCategory($category, $searchKey)
    {
        return $this->builder->select([
            'tp.typeid',
            'tp.typename',
            'tp.typecode',
        ])->join('master.stcategory as cat', 'cat.catid = tp.catid')
            ->where('cat.catcode', $category)
            ->groupStart()
            ->like('trim(lower(tp.typename))', "%$searchKey%")
            ->groupEnd()
            ->orderBy('tp.typename')
            ->get()->getResultObject();
    }

    public function validCode($code, $id = null)
    {
        if (empty($code)) return true;

        $query = $this->builder->where('trim(lower(typecode))', $code);

        if (!is_null($id)) $query->where("tp.typeid != $id");


        return $query->get()->getFirstRow() == null;
    }

    public function oneByCode($code)
    {
        $query = $this->builder->where('trim(lower(typecode))', $code);
        return $query->get()->getRowObject();
    }

    public function in($codes)
    {
        return $this->builder->select([
            'tp.typeid',
            'tp.typecode',
            'tp.typename',
        ])->whereIn('tp.typecode', $codes)
            ->get()
            ->getResultObject();
    }

    public function getOne($id)
    {
        return $this->builder
            ->select(
                'tp.typeid,
                tp.typecode,
                tp.typename,
                tp.catid,
                tp.payload,
                c.catcode,
                c.catname'
            )->join('master.stcategory as c', 'c.catid=tp.catid')
            ->where('tp.typeid', $id)
            ->limit(1)
            ->get()->getRowObject();
    }

    public function byCategory($catid)
    {
        return $this->builder->select([
            'tp.typeid',
            'tp.typecode',
            'tp.typename',
            'tp.payload'
        ])->where('tp.catid', $catid)
            ->orderBy('tp.typename')
            ->get()
            ->getResultObject();
    }

    public function getByCatCode($catcode)
    {
        return $this->builder->select([
            'tp.typeid',
            'tp.typecode',
            'tp.typename',
            'tp.payload'
        ])->join('master.stcategory as c', 'c.catid=tp.catid')
            ->where('lower(c.catcode)', strtolower($catcode))
            ->orderBy('tp.typename')
            ->get()
            ->getResultObject();
    }
}
