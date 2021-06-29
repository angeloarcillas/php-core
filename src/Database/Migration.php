<?php

namespace Zeretei\PHPCore\Database;

use \Zeretei\PHPCore\Database\QueryBuilder;

class Migration extends QueryBuilder
{
    // protected function createTable()
    // {
    //     $sql = "CREATE TABLE IF NOT EXISTS migrations (
    //         id INT AUTO_INCREMENT PRIMARY KEY,
    //         migration VARCHAR(55),
    //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    //     )";
    //     // execute
    // }

    public function apply()
    {
        //? instead of creating own mig table, create a file same w/ other
        // create migrations table
        // get applied migrations

        // scan dir for migration files
        // filter applied migration

        // loop through migration
        // create instance
        // call up method to apply migration

        // check if any migration applied
        // save migration file name
        // else log no migration applied
    }

    protected function getAppliedMigrations()
    {
        $sql = "SELECT migration FROM migrations";
        // return all fetched migrations
    }

    protected function saveMigrations(array $newMigrations)
    {
        $migrations = "(mig1), (mig2), (mig3)...";
        $sql = "INSERT INTO migrations (migration) VALUES $migrations";
        // execute
    }
}
