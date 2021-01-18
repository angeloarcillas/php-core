<?php

namespace Core\Blueprint;

use Core\Database\QueryBuilder;

abstract class Models
{
    protected $table;
    protected $fillable;
    protected $key = 'id';

    // query raw sql
    public function query(string $sql, array $params)
    {
        return $this->conn()->rawQuery($sql, $params);
    }

    // insert data
    public function save(array $params): bool
    {
        $params = $this->filter($params);
        return $this->conn()->insert($this->table, $params);
    }

    // update data
    public function update($id, $params, $key = null)
    {
        $this->key = $key ?? [$this->key => $id];

        $params = $this->filter($params);

        return $this->conn()->update($this->table, $key, $params);
    }

    // delete data
    public function delete($id, $key = null)
    {
        $this->key = $key ?? [$this->key => $id];

        return $this->conn()->delete($this->table, $id);
    }

    // find 1 data
    public function find(string $params, $key = null): bool|object
    {
        $this->key = $key ?? $this->key;

        $sql = sprintf('SELECT * FROM %s WHERE %s = ?',
            $this->table, $this->key);

        return $this->conn()->rawSelect($sql, [$params]);
    }

    // return all data
    public function all(?string $table = null): array
    {
        $this->table = $table ?? $this->table;

        return $this->conn()->selectAll($this->table);
    }

    // public function count()
    // {
    //     return $this->conn()->rowCount()
    // }

    // filter request and fillable
    protected function filter($params)
    {
        return array_filter($params,
            fn($x, $key) => in_array($key, $this->fillable)
            , ARRAY_FILTER_USE_BOTH);
    }

    // create connection instance
    private function conn()
    {
        return new QueryBuilder();
    }
}
