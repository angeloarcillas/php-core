<?php

namespace Zeretei\PHPCore\Database;

abstract class Connection
{
    /**
     * Establish connection to database
     * 
     * @param array $config
     * 
     */
    protected static function connect(array $config): \PDO
    {
        return new \PDO(
            $config['connection'] . ';dbname=' . $config['name'],
            $config['username'],
            $config['password'],
            $config['options']
        );
    }
}
