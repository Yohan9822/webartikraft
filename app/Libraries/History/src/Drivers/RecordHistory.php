<?php

namespace App\Libraries\History\src\Drivers;

use App\Libraries\History\src\Providers\MappingColumnProvider;
use App\Libraries\History\src\Vars\MapAction;
use App\Libraries\History\src\Vars\MappingConfig;
use App\Models\Master\Msusergroup;
use Exception;

class RecordHistory
{

    /**
     * Config varible
     *
     * @var MappingConfig
     */
    protected $config;

    protected $values = [];

    /**
     * Provider Column
     *
     * @var MappingColumnProvider
     * 
     */
    protected $provider;

    protected $inserts = [];

    protected $rules;

    protected $relations = [];

    protected $verbs = [
        MapAction::add => 'added',
        MapAction::update => 'updated',
        MapAction::release => 'released',
        MapAction::unrelease => 'unreleased',
        MapAction::delete => 'deleted'
    ];

    public function __construct($config = null, $values = null)
    {
        $this->rules = [
            '{created_by}' => getSession('name'),
            '{created_date:date|d F Y H:i:s}' => date('d F Y H:i:s'),
        ];

        if (!is_null($values)) $this->setValue($values);

        if (!is_null($config))
            $this->setConfig($config);
    }

    public function setValue($values)
    {
        if ((is_array($values) && !isset($values[0])) || is_object($values)) {
            $this->values = [$values];
        } else $this->values = $values;

        return $this;
    }

    public function setReferenceValue($value)
    {
        $this->config->setReferenceValue($value);

        return $this;
    }

    public function isExistInValue($object, $field)
    {
        if (is_object($object))
            return property_exists($object, $field);

        if (is_array($object))
            return isset($object[$field]);

        return false;
    }

    public function value($object, $field)
    {
        if (is_object($object))
            return property_exists($object, $field) ? $object->$field : null;

        if (is_array($object))
            return isset($object[$field]) ? $object[$field] : null;

        return null;
    }

    public function setConfig($config)
    {
        $this->config = $config;

        if (!is_null($this->config->getId()) && !is_array($this->config->getId()))
            $this->config->setId([$this->config->getId()]);
        else if (is_null($this->config->getId()))
            $this->config->setId(
                array_map(
                    function ($value, $i) {
                        if (!isset($value[$this->config->getPrimaryKey()]))
                            throw new Exception("Undefined primary key in value history");

                        return $value[$this->config->getPrimaryKey()];
                    },
                    $this->values ?? [],
                    array_keys($this->values ?? [])
                )
            );

        $ids = $this->config->getId();
        foreach ($this->values as $i => $value) {

            if (is_array($value)) {
                if (!isset($value[$this->config->getPrimaryKey()]) && isset($ids[$i]))
                    $this->values[$i][$this->config->getPrimaryKey()] = $ids[$i];
            } else if (is_object($value)) {
                if (empty($value->{$this->config->getPrimaryKey()}) && isset($ids[$i]))
                    $this->values[$i]->{$this->config->getPrimaryKey()} = $ids[$i];
            }
        }

        $this->provider = MappingColumnProvider::getInstance($this->config, false);

        $this->rules['{action_name}'] = $this->verbs[$this->config->getAction()] ?? $this->config->getAction();

        if ($this->config->getAction() == MapAction::delete)
            $this->setValue($this->provider->row());

        return $this;
    }

    public function setRules($rules)
    {
        $this->rules = array_merge($this->rules, $rules);
    }

    public function run($config = null, $save = true)
    {
        if (!is_null($config)) $this->setConfig($config);

        if (count($this->values) == 0 && $this->config->getAction() == MapAction::delete)
            $this->values = [$this->config->getPrimaryKey() => null];

        foreach ($this->provider->columns() as $column) {

            if ($this->config->getAction() == MapAction::delete) {
                foreach ($this->provider->row() as $row) {
                    $primaryVal = $this->value($row, $this->config->getPrimaryKey());
                    $rowValue = $this->value($row, $column->getColumnName());

                    $this->rules['{before_value}'] = $this->value($row, $column->getColumnName());
                    $this->rules['{after_value}'] = null;

                    $insert = [
                        'tablename' => $this->config->getTable(),
                        'columnname' => $column->getColumnName(),
                        'pkid' => $primaryVal,
                        'refid' => $this->config->getReferenceValue(),
                        'idbefore' => null,
                        'valuebefore' => $rowValue,
                        'idafter' => null,
                        'valueafter' => null,
                        'status' => $this->config->getAction(),
                        'remark' => ucfirst($column->getFormattedRemark($this->rules)),
                        'createdby' => $this->config->getUserId(),
                        'createddate' => date('Y-m-d H:i:s'),
                        'createdname' => $this->config->getFullName(),
                    ];

                    $payload = $column->payload();
                    if (!empty($payload)) {
                        $relation = $payload->relation;

                        if (!array_key_exists($relation->tablename, $this->relations)) {
                            $this->relations[$relation->tablename] = [];
                        }

                        if (!array_key_exists($relation->foreignkey, $this->relations[$relation->tablename])) {
                            $this->relations[$relation->tablename][$relation->foreignkey] = (object) [
                                'columnvalue' => $relation->columnvalue,
                                'values' => []
                            ];
                        }

                        if (!empty($rowValue) && !in_array($rowValue, $this->relations[$relation->tablename][$relation->foreignkey]->values))
                            $this->relations[$relation->tablename][$relation->foreignkey]->values[$rowValue] = null;

                        $insert['foreignkey'] = implode(',', [$relation->tablename, $relation->foreignkey]);
                    }

                    $this->inserts[] = $insert;
                }
            } else {
                foreach ($this->values as $value) {

                    $primaryVal = $this->value($value, $this->config->getPrimaryKey());

                    $providerVal = $this->provider->getVal($primaryVal, $column->getColumnName());
                    $currentVal = $this->value($value, $column->getColumnName());

                    if (trim($providerVal) == trim($currentVal) || !$this->isExistInValue($value, $column->getColumnName())) continue;

                    if ($this->config->getAction() == MapAction::add)
                        $providerVal = null;

                    $this->rules['{before_value}'] = $providerVal;
                    $this->rules['{after_value}'] = $currentVal;

                    $insert = [
                        'tablename' => $this->config->getTable(),
                        'columnname' => $column->getColumnName(),
                        'pkid' => $primaryVal,
                        'refid' => $this->config->getReferenceValue(),
                        'idbefore' => null,
                        'valuebefore' => $providerVal,
                        'idafter' => null,
                        'valueafter' => $currentVal,
                        'status' => $this->config->getAction(),
                        'remark' => ucfirst($column->getFormattedRemark($this->rules)),
                        'createdby' => $this->config->getUserId(),
                        'createddate' => date('Y-m-d H:i:s'),
                        'createdname' => $this->config->getFullName(),
                    ];

                    $payload = $column->payload();
                    if (!empty($payload)) {
                        $relation = $payload->relation;

                        if (!array_key_exists($relation->tablename, $this->relations)) {
                            $this->relations[$relation->tablename] = [];
                        }

                        if (!array_key_exists($relation->foreignkey, $this->relations[$relation->tablename])) {
                            $this->relations[$relation->tablename][$relation->foreignkey] = (object) [
                                'columnvalue' => $relation->columnvalue,
                                'values' => []
                            ];
                        }

                        if (!empty($providerVal) && !in_array($providerVal, $this->relations[$relation->tablename][$relation->foreignkey]->values))
                            $this->relations[$relation->tablename][$relation->foreignkey]->values[$providerVal] = null;

                        if (!empty($currentVal) && !in_array($currentVal, $this->relations[$relation->tablename][$relation->foreignkey]->values))
                            $this->relations[$relation->tablename][$relation->foreignkey]->values[$currentVal] = null;

                        $insert['foreignkey'] = implode(',', [$relation->tablename, $relation->foreignkey]);
                    }

                    $this->inserts[] = $insert;
                }
            }
        }

        if ($save) return $this->save();

        return $this;
    }

    public function save()
    {
        if (count($this->relations) > 0) {
            foreach ($this->relations as $tablename => $relation) {

                foreach ($relation as $foreignkey => $config) {

                    $results = db_connect()->table($tablename)
                        ->select([$foreignkey, $config->columnvalue])
                        ->whereIn($foreignkey, array_keys($config->values))
                        ->get()
                        ->getResultObject();

                    foreach ($results as $db) {
                        $config->values[$db->{$foreignkey}] = $db->{$config->columnvalue};
                    }
                }
            }
        }

        if (count($this->inserts) > 0) {

            foreach ($this->inserts as $i => $insert) {
                if (isset($insert['foreignkey'])) {
                    list($tablename, $foreignkey) = explode(",", $insert['foreignkey']);
                    unset($this->inserts[$i]['foreignkey']);

                    $foreign = $this->relations[$tablename][$foreignkey];

                    if (isset($foreign->values[$insert['valuebefore']])) {
                        $idbefore = intval($insert['valuebefore']);
                        $this->inserts[$i]['valuebefore'] = $foreign->values[$insert['valuebefore']];
                        $this->inserts[$i]['idbefore'] = $idbefore;
                    }

                    if (isset($foreign->values[$insert['valueafter']])) {
                        $idafter = intval($insert['valueafter']);
                        $this->inserts[$i]['valueafter'] = $foreign->values[$insert['valueafter']];
                        $this->inserts[$i]['idafter'] = $idafter;
                    }
                }
            }

            $inserted = db_connect()->table('loghistory')->insertBatch($this->inserts);

            if (!$inserted)
                throw new Exception('InsertHistory: Failed to create history data' . implode('<br />', db_connect()->error()));
        }

        return true;
    }
}
