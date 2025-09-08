<?php

namespace App\Helpers\Utilities;

use Exception;

trait StaticArray
{
    protected $data;

    public function __construct($data)
    {
        if (!is_array($data))
            throw new Exception("Invalid type arrray");

        if (method_exists($this, '__collection'))
            $this->data = array_map(
                function ($data) {
                    return call_user_func([$this, '__collection'], $data);
                },
                $data
            );
        else $this->data = $data;
    }

    public function filter($callable)
    {
        return array_filter(
            $this->data,
            $callable
        );
    }
}
