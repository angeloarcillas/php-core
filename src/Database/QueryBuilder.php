<?php

namespace Zeretei\PHPCore\Database;

/**
 * TODO: Add error handling
 */
class QueryBuilder
{
    /**
     * PDO instnace
     * 
     * @var \PDO
     */
    protected \PDO $pdo;

    /**
     * Establish connection
     */
    public function __construct($config)
    {
        $this->pdo = new \PDO(
            $config['connection'] . ';dbname=' . $config['name'],
            $config['username'],
            $config['password'],
            $config['options']
        );
    }

    /**
     * Query a SQL statement
     */
    public function query($sql, $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Fetch a single row from database
     */
    public function fetch($sql, $params = []): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Fetch all row from database
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Count all rows from database
     */
    public function count(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Execute a SQL command
     */
    public function execute(string $sql): int|false
    {
        return $this->pdo->exec($sql);
    }
}
