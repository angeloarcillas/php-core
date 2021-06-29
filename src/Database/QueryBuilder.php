<?php

namespace Zeretei\PHPCore\Database;

abstract class QueryBuilder
{

    public function query($sql, $params = [])
    {
        $stmt = $this->conn()->prepare($sql);
        return $stmt->execute($params);
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Establish connection
    private function conn()
    {
        // TODO: revamp app to "Keep it simple approach"
        return new \PDO(
            $this->config['connection'] . ';dbname=' . $this->config['name'],
            $this->config['username'],
            $this->config['password'],
            $this->config['options']
        );
    }
}
