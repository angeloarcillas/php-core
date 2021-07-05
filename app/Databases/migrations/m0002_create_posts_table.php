<?php

use Zeretei\PHPCore\Application;

class CreatePostsTable
{
    public function up()
    {
        $sql = "CREATE TABLE posts (
                  id int NOT NULL AUTO_INCREMENT,
                  title varchar(255),
                  body text,
                  updated_at TIMESTAMP,
                  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                  user_id int NOT NULL,
                  PRIMARY KEY (id),
                  FOREIGN KEY (user_id) REFERENCES users(id)
                )";

        return $sql;
    }

    public function down()
    {
        $sql = "DROP TABLE users";
        Application::get('database')->execute($sql);
    }
}
