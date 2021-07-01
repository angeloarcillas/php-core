<?php

namespace Zeretei\PHPCore\Database;

use Zeretei\PHPCore\Application;

/**
 * TODO: Refactor
 */
class Migration
{
    /**
     * Create table for applied migrations
     */
    protected function createMigrationsTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(55),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        return Application::get('database')->execute($sql);
    }

    /**
     * Apply all available migration
     */
    public function apply(): bool
    {
        // create migration table
        $this->createMigrationsTable();

        // get all applied migrations
        $appliedMigrations = $this->getAppliedMigrations();

        // scan dir for migrations
        $path = app('path.database') . '/migrations';
        $migrations = array_diff(scandir($path), ['.', '..']);

        // filter migrated migrations
        $toApplyMigrations = array_diff($migrations, $appliedMigrations);

        // new applied migrations placeholder
        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            // get class name of file
            $class = $this->getClassname($migration);

            // import migration file
            $path = Application::getInstance()->get('path.database');
            require_once $path . '/migrations/' . $migration;


            // create class instance
            $object = new $class();

            // get sql
            $sql = $object->up();

            // run sql
            Application::get('database')->execute($sql);

            // append applied migration
            $newMigrations[] = $migration;
        }

        // save applied migration file name
        $this->saveMigrations($newMigrations);

        return true;
    }

    /**
     * Get all applied migration
     */
    protected function getAppliedMigrations(): array
    {
        $sql = "SELECT migration FROM migrations";

        // get all migration
        $migrations = Application::get('database')->fetchAll($sql);
        // convert to single column
        return  array_map(fn ($i) => $i->migration, $migrations);
    }

    /**
     * Save applied migrations
     */
    protected function saveMigrations(array $migrations): bool
    {
        // count applied migrations
        $count = count($migrations);

        // return if none
        if ($count === 0) return false;

        // set params
        $params = trim(str_repeat("(?),", $count), ',');

        $sql = "INSERT INTO migrations (migration) VALUES $params";

        // save newly applied migration
        return Application::get('database')->query($sql, $migrations);
    }

    /**
     * Get class name of file
     */
    protected function getClassname(string $migration): string
    {
        // get filename w/out extension
        $filename = pathinfo($migration, PATHINFO_FILENAME);
        // remove migration version
        $migration = array_slice(explode('_', $filename), 1);
        // capitalize then join array
        $className = implode('', array_map('ucfirst', $migration));
        // return class name
        return $className;
    }
}
