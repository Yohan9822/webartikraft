<?php

namespace App\Libraries\History\src\Vars;

use App\Helpers\Utilities\StaticCollection;

/**
 * Mapping Column
 * 
 * @method int getId(mixed $default = null)
 * @method string getTableName(mixed $default = null)
 * @method string getColumnName(mixed $default = null)
 * @method string getRemark(mixed $default = null)
 */
class MappingColumn
{
    use StaticCollection;

    protected $dataStyle = '';

    /**
     * Get formatted remark
     *
     * @param array $rules
     * @return string
     */
    public function getFormattedRemark($rules = [])
    {
        $remark = $this->getRemark();

        foreach ($rules as $key => $value) {
            $remark = str_replace($key, $value, $remark);
        }

        return $remark;
    }

    public function payload()
    {
        return json_decode($this->getPayload());
    }
}
