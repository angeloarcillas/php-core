<?php

class Connection
{
    public static function connect($config)
    {
        var_dump($config);
    }
}


class Database extends Connection
{
    public function __construct($config)
    {
        parent::connect($config);
    }

    public function applyMigration()
    {
        // create migration table
        // get all migrated table
        // scan migration files
        // separate applied migration
        // apply migration
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations();

        // get all files from migrations folder
        $files = scandir(__DIR__ . '/migrations');

        // $scanned_directory = array_diff(scandir($directory), array('..', '.'));      
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        // get migration class
        $table = new Table();
        $migration->up($table);
    }
    public function createMigrationTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNOB;";
    }
    public function getAppliedMethods()
    {
        $sql = "SELECT migration FROM migrations";
        // return fetch all(\PDO::FETCH_COLUMN)
    }
    public function saveMigration($migrations)
    {
        // ('migration_100'), ('migration_200'), ('migration_300')
        $str = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $sql = "INSERT INTO migrations (migration) VALUES $str";

    }
}
