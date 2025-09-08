<?php

namespace App\Libraries\History;

use App\Libraries\History\src\Drivers\RecordHistory;
use App\Libraries\History\src\Vars\MappingConfig;

/**
 * History Process
 * 
 * @method static RecordHistory record(MappingConfig $config = null, array|mixed $values = null)
 */
class HistoryProcess
{

    static protected $drivers = [
        'record' => RecordHistory::class,
    ];

    public static function __callStatic($arguments, $parameters)
    {
        $driver = self::$drivers[$arguments];
        return new $driver(...$parameters);
    }
}
