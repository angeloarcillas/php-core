<?php

use Zeretei\PHPCore\Application;

class CreateFoosTable
{
    public function up()
    {
        $sql = "CREATE TABLE foos (
                id int(55) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name varchar(55),
                email varchar(55) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

        return $sql;
    }

    public function down()
    {
        $sql = "DROP TABLE foos";
        Application::get('database')->execute($sql);
    }
}
