<?php

namespace Zeretei\PHPCore\Database;

use \Zeretei\PHPCore\Application;

class Migration
{
    /**
     * Apply all the available migration
     */
    public function apply()
    {
        if (!Application::exitst('database')) {
            throw new \Exception("Please setup a database.");
        }

        if (!Application::exitst('path.databases')) {
            throw new \Exception("Please setup a migration path.");
        }

        // TODO: rename $path to a more informative name ($migration_dir_path)
        $path = Application::get('path.databases') . '/migrations';

        if (!file_exists($path) || !is_dir($path)) {
            throw new \Exception(
                sprintf('Directory: "%s" does not exists.', $path)
            );
        }

        $this->createMigrationsTable();

        $appliedMigrations = $this->getAppliedMigrations();

        $migrations = array_diff(scandir($path), ['.', '..']);
        $toApplyMigrations = array_diff($migrations, $appliedMigrations);

        $newMigrations = [];

        foreach ($toApplyMigrations as $migration) {
            require_once $path ."/". $migration;

            $class = $this->getClassname($migration);

            if (!class_exists($class)) {
                throw new \Exception(
                    sprintf('Class: "%s" does not exists on FILE: "%s".', $class, $migration)
                );
            }

            $object = new $class();

            if (!method_exists($object::class, 'up')) {
                throw new \Exception(sprintf(
                    'Method: "up()" does not exists on Class: "%s" in File: "%s".',
                    $object::class,
                    $migration
                ));
            }

            $sql = $object->up();

            if (!is_string($sql)) {
                throw new \Exception("Method: up() must return a sql syntax.");
            }

            Application::get('database')->execute($sql);

            $newMigrations[] = $migration;
        }

        $this->saveMigrations($newMigrations);

        return $newMigrations;
    }

    /**
     * Create applied migrations table
     */
    protected function createMigrationsTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        return Application::get('database')->execute($sql);
    }

    /**
     * Get all applied migration
     */
    protected function getAppliedMigrations(): array
    {
        $sql = "SELECT migration FROM migrations";
        $migrations = Application::get('database')->fetchAll($sql);
        return  array_map(fn ($i) => $i['migration'], $migrations);
    }

    /**
     * Save applied migrations
     */
    protected function saveMigrations(array $migrations): bool
    {
        $count = count($migrations);

        if ($count === 0) return false;

        $params = trim(str_repeat("(?),", $count), ',');
        $sql = "INSERT INTO migrations (migration) VALUES $params";

        return Application::get('database')->query($sql, $migrations);
    }

    /**
     * Get class name of file
     */
    protected function getClassname(string $migration): string
    {
        $filename = pathinfo($migration, PATHINFO_FILENAME);
        $migration = array_slice(explode('_', $filename), 1);
        $className = implode('', array_map('ucfirst', $migration));
        return $className;
    }
}
