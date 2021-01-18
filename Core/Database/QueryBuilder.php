<?php
namespace Core\Database;

final class QueryBuilder extends Connection
{

    public $validFetchType = ['fetch', 'fetchAll'];

    /**
     * Raw SQL query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawQuery(string $sql, array $params = []): bool
    {
        return $this->query($sql, $params);
    }

    /**
     * Raw SQL select query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawSelect(string $sql, array $params = []): bool|object
    {
        return $this->query($sql, $params, 'fetch');
    }

    /**
     * Raw SQL select all query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawSelectAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params, 'fetchAll');
    }

    /**
     * Raw SQL row count query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawCount(string $sql, array $params = []): array
    {
        return $this->query($sql, $params, 'fetchAll', true);
    }

    // Do insert sql
    public function insert(string $table, array $params)
    {
        $columns = implode(',', array_keys($params));
        $values = trim(str_repeat('?,', count($params)), ',');

        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $table, $columns, $values);
        return $this->query($sql, $params);
    }

    // do update sql
    public function update(string $table, array $key, array $params)
    {
        $set = trim(implode('=?,', array_keys($params)) . '=?', ',');

        $sql = sprintf('UPDATE %s SET %s WHERE %s = ?',
            $table, $set, array_keys($key));

        array_push($params, $key);
        return $this->query($sql, $params);
    }

    // do delete sql
    public function delete(string $table, array $key, array $params = [])
    {
        $sql = sprintf('DELETE FROM %s WHERE %s = ?',
            $table, array_keys($key)
        );

        array_push($params, $key);
        $this->query($sql, $params);
    }

    /**
     * Select from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function select(string $table, array $params = ['*']): bool | object
    {
        $sql = sprintf("SELECT %s FROM %s",
            implode(',', $params),
            $table
        );

        return $this->query($sql, $params, 'fetch');
    }

    /**
     * Select all from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function selectAll(string $table, array $params = ['*']): array
    {
        $sql = sprintf("SELECT %s FROM %s",
            implode(',', $params),
            $table
        );

        return $this->query($sql, fetchType:'FetchAll');
    }

    // /**
    //  * Count all rows from database
    //  *
    //  * @param string $sql
    //  * @param array $params
    //  * @return int
    //  */
    // public function rowCount(string $sql, array $params = []): int
    // {
    //     $sql = "SELECT * FROM %s";
    //     return $this->query($sql, $params, 'fetchAll', count:true);
    // }

    private function connection()
    {
        return parent::connect(CONFIG['database']);
    }

    private function query(
        string $sql,
        array $params = [],
        ?string $fetchType = null,
        bool $count = false
    ) {
        $stmt = $this->connection()->prepare($sql);

        $params = array_keys($params);

        if (!$fetchType) {
            return $stmt->execute($params);
        }

        if (! in_array($fetchType, $this->validFetchType)) {
            throw new \Exception("{$fetchType} is an invalid Fetch Type.");
        }

        $stmt->execute($params);
        $result = $stmt->{$fetchType}();

        if ($count) {
            return $result->rowCount();
        }

        return $result;

    }
}
