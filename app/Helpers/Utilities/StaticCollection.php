<?php

namespace App\Helpers\Utilities;

use Exception;

/**
 * Trait Static Collection
 * 
 * @method mixed set(string $key, mixed $value)
 * @method mixed get(mixed $default = null)
 */
trait StaticCollection
{

    protected $data = [];

    public function __construct($data)
    {

        if (is_string($data) && count(func_get_args()) > 0)
            $this->data = func_get_args();
        else if (is_null($data)) $data = [];

        array_walk(
            $data,
            function (&$val, $key) {
                $this->data[preg_replace('/[\_\s]/', '', $key)] = $val;
            }
        );
    }

    public function __call($name, $arguments)
    {
        $methodPrefix = substr($name, 0, 3);
        $key = strtolower(substr($name, 3));

        if ($name == 'get' && count($arguments) >= 1) {
            $key = $arguments[0];
            if (is_object($this->data))
                return property_exists($this->data, $key) ? $this->data->$key : @$arguments[1];

            if (is_array($this->data))
                return isset($this->data[$key]) ? $this->data[$key] : @$arguments[1];

            return $arguments[1];
        } else if ($name == 'set' && count($arguments) == 2) {
            $key = $arguments[0];

            if (is_object($this->data))
                $this->data->$key = $arguments[1];

            if (is_array($this->data))
                $this->data[$key] = $arguments[1];

            return $this;
        } else if ($methodPrefix == 'set' && count($arguments) == 1) {

            if (is_array($this->data))
                $this->data[$key] = $arguments[0];


            if (is_object($this->data))
                $this->data->$key = $arguments[0];

            return $this;
        } elseif ($methodPrefix == 'get') {

            if (is_array($this->data)) return isset($this->data[$key]) && !is_null($this->data[$key]) ? $this->data[$key] : @$arguments[0];

            if (is_object($this->data)) return property_exists($this->data, $key) && !is_null($this->data->$key) ? $this->data->$key : @$arguments[0];

            return isset($arguments[0]) ? $arguments[0] : null;
        } else {
            throw new Exception('Opps! The method is not defined!');
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    public function toJson()
    {
        if (empty($this->data) || (is_array($this->data) && count($this->data) == 0))
            return null;

        return  json_encode($this->toArray());
    }
}
