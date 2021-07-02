<?php

namespace Zeretei\PHPCore\Database;

use Zeretei\PHPCore\Application;

class Migration
{
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
     * Apply all available migration
     */
    public function apply(): bool
    {
        $this->createMigrationsTable();

        $appliedMigrations = $this->getAppliedMigrations();

        if (!Application::exitst('path.database')) {
            throw new \Exception("Please register a migration path to container.");
        }

        $path = Application::get('path.database') . '/migrations';
        $migrations = array_diff(scandir($path), ['.', '..']);
        $toApplyMigrations = array_diff($migrations, $appliedMigrations);

        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            $class = $this->getClassname($migration);
            $path = Application::get('path.database');
            require_once $path . '/migrations/' . $migration;
            $object = new $class();
            $sql = $object->up();
            Application::get('database')->execute($sql);
            $newMigrations[] = $migration;
        }

        $this->saveMigrations($newMigrations);
        return true;
    }

    /**
     * Get all applied migration
     */
    protected function getAppliedMigrations(): array
    {
        $sql = "SELECT migration FROM migrations";
        $migrations = Application::get('database')->fetchAll($sql);
        return  array_map(fn ($i) => $i->migration, $migrations);
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
