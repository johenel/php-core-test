<?php 

namespace app\Http\Models;

class Model 
{
    protected $table;
    protected $selects = [];
    protected $wheres = [];
    protected $joins = [];

    public static function __callStatic($name, $arguments)
    {
        return self::$name($arguments);
    }

    public function select(array $columns)
    {
        $this->selects = $columns;

        return $this;
    }

    public function where($column, $operation, $value)
    {
        $this->wheres[] = "{$column} {$operation} '{$value}'";

        return $this;
    }

    public function join($table, $column1, $operation, $column2, $type = 'inner')
    {
        $this->joins[] = "{$type} join {$table} on ({$column1} {$operation} {$column2})";

        return $this;
    }

    public function leftJoin($table, $column1, $operation, $column2)
    {
        return $this->join($table, $column1, $operation, $column2, 'left');
    }

    public function get()
    {
        $query = $this->generateQuery();

        return collect(query($query));
    }

    private function generateQuery()
    {
        $query = "select * from {$this->table} ";

        if (count($this->selects) > 0) {
            $select_query = implode(',', $this->selects);
            $query = "select {$select_query} from {$this->table} ";
        }

        if (count($this->joins) > 0) {
            $join_query = implode(' ', $this->joins);
            $query .= "{$join_query} ";
        }

        if (count($this->wheres) > 0) {
            $where_query = implode('and', $this->wheres);
            $query .= "where {$where_query}";
        }

        return $query;
    }
}