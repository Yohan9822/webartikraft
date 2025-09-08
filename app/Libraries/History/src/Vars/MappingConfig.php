<?php

namespace App\Libraries\History\src\Vars;

use App\Libraries\History\src\Collections\CreateHistoryCollection;
use App\Helpers\Utilities\StaticCollection;

/**
 * Mapping Config Collection
 * 
 * @method string getTable(mixed $default = null)
 * @method string getPrimaryKey(mixed $default = null)
 * @method mixed getId(mixed $default = null)
 * @method void setReferenceValue($value)
 * @method mixed getReferenceValue(mixed $default = null)
 * @method string getAction(mixed $default = null)
 * @method int getUserId(mixed $default = null)
 * @method string getFullName(mixed $default = null)
 */
class MappingConfig
{
    use StaticCollection;

    protected $dataStyle = 'default';

    public static function msuser($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.msuser',
            'primarykey' => 'userid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function msaccessgroup($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.msaccessgroup',
            'primarykey' => 'accessgroupid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function mscompany($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.mscompany',
            'primarykey' => 'companyid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function msmaterial($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.msmaterial',
            'primarykey' => 'materialid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function mslamination($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.mslamination',
            'primarykey' => 'laminationid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function msshape($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.msshape',
            'primarykey' => 'shapeid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function mscustomer($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.mscustomer',
            'primarykey' => 'customerid',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }

    public static function msaddress($referenceValue = null, $action = MapAction::add, $id = null)
    {
        return CreateHistoryCollection::mapConfig([
            'table' => 'master.msaddress',
            'primarykey' => 'id',
            'id' => $id ?? $referenceValue,
            'referencevalue' => $referenceValue,
            'userid' => getSession('userid'),
            'fullname' => getSession('name'),
            'action' => $action,
        ]);
    }
}
