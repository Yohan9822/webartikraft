<?php

use App\Models\Master\Msconfig;

class AppsConfig
{

    public static $instance;

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new AppsConfig();
        }

        return self::$instance;
    }

    protected $configs = [];

    public function __construct()
    {
        $this->configs = (new Msconfig)->all();
    }

    public function get($code, $key = null, $default = null, $throwable = false)
    {
        $filter = array_filter(
            $this->configs,
            function ($config) use ($code) {
                return $config->configcode == $code;
            }
        );

        if (count($filter) == 0 && $throwable)
            throw new \Exception("Undefined app config, please define config $code config in Master -> Config");

        $row = array_shift($filter);
        if (is_null($row) && !$throwable) $row = (object) ['isactive' => false, 'payload' => ''];

        if (!is_null($row) && !is_null($key)) return $row->$key ?? $default;

        return $row;
    }

    public function getThrowable($code, $key = null, $default = null)
    {
        return $this->get($code, $key, $default, true);
    }
}
