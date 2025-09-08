<?php

namespace App\Models;

class BaseModel
{

    protected $table;

    protected $tableAlias;

    protected $primaryKey;

    protected $db;

    protected $builder;

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }

    protected function setFindQuery()
    {
        return $this->builder;
    }

    public function all()
    {
        return $this->builder->get()
            ->getResultObject();
    }

    public function find($id)
    {
        $query = $this->setFindQuery();

        $columnKey = $this->primaryKey;
        if (!empty($this->tableAlias))
            $columnKey = implode('.', [$this->tableAlias, $this->primaryKey]);

        $query = $query->where($columnKey, $id);

        return $query->get()->getFirstRow();
    }

    public function store($values)
    {
        return $this->builder->insert($values);
    }

    public function edit($values, $id, $primaryKey = null)
    {
        return $this->builder->update($values, [$primaryKey ?? $this->primaryKey => $id]);
    }

    public function destroy($id, $primaryKey = null)
    {
        return $this->builder->delete([$primaryKey ?? $this->primaryKey => $id]);
    }

    public function storeBatch($values)
    {
        return $this->builder->insertBatch($values);
    }

    public function deleteBatch($ids)
    {
        return $this->builder->whereIn($this->primaryKey, $ids)
            ->delete();
    }

    public function lastId()
    {
        $columnKey = $this->primaryKey;
        if (!empty($this->tableAlias))
            $columnKey = implode('.', [$this->tableAlias, $this->primaryKey]);

        $query = $this->builder->select("$columnKey as max_id")
            ->orderBy($columnKey, 'desc')->limit(1)
            ->getCompiledSelect();

        $row = $this->db->query("$query FOR UPDATE")
            ->getFirstRow();

        return !is_null($row) ? $row->max_id : 0;
    }
}
