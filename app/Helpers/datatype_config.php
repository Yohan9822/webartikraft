<?php

namespace App\Helpers;

use App\Models\Settings\Stcategory;
use App\Models\Settings\Sttype;
use Exception;

class DataTypeConfig
{

    /**
     * Class DataTypeConfig
     *
     * @var DataTypeConfig
     */
    static public $instances;

    static public function instance($code = null)
    {
        if (is_null(self::$instances))
            self::$instances = new DataTypeConfig();

        if (!is_null($code)) self::$instances->find($code);

        return self::$instances;
    }

    protected $types = [];

    public function find($code)
    {
        $codes = is_array($code) ? $code : [$code];

        $paramCodes = array_filter(
            $codes,
            function ($code) {
                if (!isset($this->types[$code])) return true;

                if (is_null($this->types[$code])) return true;

                return false;
            }
        );

        $results = (new Sttype)->in($paramCodes);

        foreach ($results as $result) {
            $this->types[$result->typecode] = $result;
        }

        return array_reduce(
            $codes,
            function ($carry, $item) {
                return $carry[$item] = $this->types[$item];
            }
        );
    }

    public function category($categorycode)
    {
        $category = (new Stcategory)->byCode($categorycode);

        if (is_null($category))
            throw new Exception("Invalid data category");

        return (new Sttype)->byCategory($category->catid);
    }

    public function value($key, $default = null)
    {
        return isset($this->types[$key]) ?? $default;
    }
}
