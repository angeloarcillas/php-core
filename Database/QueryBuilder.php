<?php
namespace Database;

class QueryBuilder extends Connection
{
    private object $conn;

    /**
     * Start buffer then establish connection
     */
    public function __construct(array $config)
    {
      ob_start();
      $this->conn = parent::make($config);
    }

    /**
     * Unset connection then flush buffer
     */
    public function __destruct()
    {
      unset($this->conn);
      ob_end_flush();
    }

    /**
     * Query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function query(string $sql, array $params = []): bool
    {
      return $stmt = $this->conn
        ->prepare($sql)
        ->execute($params);
    }

    /**
     * Select from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function select(string $sql, array $params = [])
    {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetch();
    }

    /**
     * Select all from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function selectAll(string $sql, array $params = [])
    {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll();
    }

    /**
     * Count all rows from database
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function rowCount(string $sql, array $params = []): int
    {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->rowCount();
    }
}

// public function select($table, array $params = ['*'])
// {
//     $sql = sprintf(
//         "SELECT %s FROM {$table}",
//         implode(",", $params)
//     );

//     $stmt = $this->conn->prepare($sql);
//     $stmt->execute($params);

//     return $stmt->fetch();
// }
