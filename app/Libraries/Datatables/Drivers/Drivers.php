<?php


namespace App\Libraries\Datatables\Drivers;


use App\Libraries\Datatables\Source\Request;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class Drivers
{

    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @param Model|BaseBuilder $query
     * @return Model|BaseBuilder
     * */
    public function filter($query)
    {
        if ($this->request->search()->isNotEmpty() && $this->request->getDatabaseColumns()->count() > 0) {
            $query->groupStart();

            $index = 0;
            $searchValue = $this->request->search()->value();

            foreach ($this->request->columns() as $i => $column) {
                if ($column->isNameEmpty() && $column->isDataNotEmpty()) {
                    $dbcolumn = $this->request->getDatabaseColumns()->get($i);

                    if (!empty($dbcolumn)) {
                        $field = $dbcolumn->name();

                        if (!empty($field)) {

                            if ($dbcolumn->isCallableRaw() && !$dbcolumn->isCallableQuery()) {
                                $index == 0
                                    ? $query->where($dbcolumn->raw($field, $dbcolumn->format($searchValue)))
                                    : $query->orWhere($dbcolumn->raw($field, $dbcolumn->format($searchValue)));
                            } else if ($dbcolumn->isCallableQuery()) {
                                $query = $dbcolumn->query($query, $dbcolumn->field($field), $dbcolumn->format($searchValue));
                            } else {

                                $index == 0
                                    ? $query->like("lower(" . $dbcolumn->field($field) . "::text)", $dbcolumn->format($searchValue))
                                    : $query->orLike("lower(" . $dbcolumn->field($field) . "::text)", $dbcolumn->format($searchValue));
                            }

                            $index++;
                        }
                    }
                } else if ($column->isNameNotEmpty()) {
                    $index == 0
                        ? $query->like("lower(" . $column->name() . ")", $searchValue)
                        : $query->orLike("lower(" . $column->name() . ")", $searchValue);

                    $index++;
                }
            }

            $query->groupEnd();
        }

        foreach ($this->request->orders() as $order) {
            $column = $this->request->getDatabaseColumns()->get($order->column());

            if (!is_null($column) && $column->isNameNotEmpty()) {
                $query->orderBy($column->orderName(), $order->dir());
            }
        }

        return $query;
    }
}
