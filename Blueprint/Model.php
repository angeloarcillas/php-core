<?php

namespace Core\Blueprint;

use Core\Database\QueryBuilder;

abstract class Model
{
    protected $table;
    protected $fillable;
    protected $key = 'id';

    public function save(array $params): bool
    {
        $columns = implode(',', $this->fillable);
        $values = trim(str_repeat('?,',count($params)),',');
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',
                    $this->table, $columns, $values);

        return $this->db()->query($sql, $params);
    }


    public function find(string $key): bool|object
    {
        $sql = sprintf('SELECT * FROM %s WHERE %s = ?',
        $this->table, $this->key);
        return $this->db()->select($sql, [$key]);
    }

    public function all(array $params=[]): array
    {
        $sql = sprintf('SELECT * FROM %s', $this->table);
        return $this->db()->selectAll($sql, $params);
    }

    public function db()
    {
        return new QueryBuilder();
    }
}
