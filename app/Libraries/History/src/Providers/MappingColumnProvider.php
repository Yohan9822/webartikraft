<?php

namespace App\Libraries\History\src\Providers;

use App\Libraries\History\src\Collections\CreateHistoryCollection;
use App\Libraries\History\src\Vars\MapAction;
use App\Libraries\History\src\Vars\MappingColumn;
use App\Libraries\History\src\Vars\MappingConfig;
use Exception;

class MappingColumnProvider
{

    public static $instance;

    public static function getInstance($config, $permanently = true)
    {
        if (is_null(self::$instance) || !$permanently) {
            self::$instance = (new MappingColumnProvider($config))->fetch();
        }

        return self::$instance;
    }

    /**
     * Mapping Congi
     *
     * @var MappingConfig
     */
    protected $config;

    protected $columns = array();

    protected $row;

    /**
     * Mapping Column Provider
     *
     * @param MappingConfig $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function fetch()
    {
        $results = db_connect()->table('master.sttablemapping as tbmap')
            ->select([
                'tbmap.mapid as id',
                'tbmap.tablename as table',
                'tbmap.columnname',
                'tbmap.remark',
                'tbmap.payload',
            ])->where('tbmap.tablename', $this->config->getTable())
            ->where('tbmap.isactive', 't')
            ->get();

        if ($results) $results = $results->getResultArray();
        else $results = [];

        $this->columns = array_map(function ($column) {
            return CreateHistoryCollection::column($column);
        }, $results);

        if (!in_array($this->config->getAction(), [MapAction::add, MapAction::other])) {
            $row = db_connect()->table($this->config->getTable())
                ->select(
                    array_merge(
                        [$this->config->getPrimaryKey()],
                        array_filter(
                            array_map(
                                function ($column) {
                                    return $column->getColumnName();
                                },
                                $this->columns
                            ),
                            function ($column) {
                                if (strpos($column, '^') > -1) return false;

                                return true;
                            }
                        )
                    )
                )
                ->whereIn($this->config->getPrimaryKey(), $this->config->getId())
                ->get();

            if ($row) $this->row = $row->getResultObject();
        }

        $this->columns = array_map(function ($column) {
            $column['columnname'] = str_replace('^', '', $column['columnname']);
            return CreateHistoryCollection::column($column);
        }, $results);

        return $this;
    }

    /**
     * Get mapping columns
     *
     * @return MappingColumn[]
     */
    public function columns()
    {
        return $this->columns;
    }

    public function row($index = null)
    {
        if (is_null($index))
            return $this->row;

        return $this->row[$index] ?? null;
    }

    public function getVal($id, $field)
    {
        if (!in_array($this->config->getAction(), [MapAction::add, MapAction::other])) {
            $filterRow = array_filter(
                $this->row(),
                function ($row) use ($id) {
                    return $row->{$this->config->getPrimaryKey()} == $id;
                }
            );

            $filteredRow = array_shift($filterRow);

            if (is_null($filteredRow))
                throw new Exception("MappingColumnProvider: Undefined row data");

            return property_exists($filteredRow, $field) ? $filteredRow->$field : null;
        }

        return null;
    }
}
