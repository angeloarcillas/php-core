<?php

namespace Core\Blueprint;

use Core\Database\QueryBuilder;

abstract class Models
{
    protected $table;
    protected $fillable;
    protected $key = 'id';

    // query raw sql
    public function rawQeury(string $sql, array $params)
    {
        return $this->build()->rawQuery($sql, $params);
    }

    // query raw select sql
    public function rawSelectQuery(string $sql, array $params)
    {
        return $this->build()->rawSelect($sql, $params);
    }

    // query raw select all sql
    public function rawSelectAllQuery(string $sql, array $params)
    {
        return $this->build()->rawSelectAll($sql, $params);
    }

    // insert data
    public function create(array $params): bool
    {
        $params = $this->filter($params);
        return $this->build()->insert($this->table, $params);
    }

    // update data
    public function update($id, $params, $key = null)
    {
        $key = $key ? [$key => $id] : [$this->key => $id];
        $params = $this->filter($params);

        return $this->build()->update($this->table, $key, $params);
    }

    // delete data
    public function delete($id, $key = null)
    {
        $key = $key ?? $this->key;
        return $this->build()->delete($this->table, $key, $id);
    }

    // find 1 data
    public function find(string $param, ?string $key = null, ?string $table = null)
    {
        $table = $table ?? $this->table;
        $key = $key ?? $this->key;
        return $this->build()->select($table, $key, $param);
    }

    // return all data
    public function all(?string $table = null): array
    {
        $this->table = $table ?? $this->table;

        return $this->build()->selectAll($this->table);
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

    // create QueryBuilder instance
    private function build()
    {
        return new QueryBuilder();
    }
}
