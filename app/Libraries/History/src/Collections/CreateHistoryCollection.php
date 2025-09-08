<?php

namespace App\Libraries\History\src\Collections;

use App\Libraries\History\src\Vars\MapAction;
use App\Libraries\History\src\Vars\MappingColumn;
use App\Libraries\History\src\Vars\MappingConfig;

/**
 * Create History Collection
 * 
 * @method static MappingConfig mapConfig(string $table, string $primaryKey, mixed $referenceValue, int $userid, string $action = MapAction::add)
 * @method static MappingColumn column(int $id, string $table, string $columnname, string $remark)
 */
class CreateHistoryCollection
{

    static protected $drivers = [
        'mapConfig' => MappingConfig::class,
        'column' => MappingColumn::class,
    ];

    public static function __callStatic($arguments, $parameters)
    {
        $driver = self::$drivers[$arguments];
        return new $driver(...$parameters);
    }
}
