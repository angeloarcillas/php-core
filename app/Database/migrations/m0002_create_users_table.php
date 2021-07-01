<?php

use Zeretei\PHPCore\Application;

class CreateUsersTable
{
    public function up()
    {
        $sql = "CREATE TABLE users (
                id int(55) AUTO_INCREMENT PRIMARY KEY,
                username varchar(55),
                email varchar(55) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

        return $sql;
    }

    public function down()
    {
        $sql = "DROP TABLE users";
        Application::get('database')->execute($sql);
    }
}
