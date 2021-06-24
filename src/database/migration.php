<?php

class Migration
{
    public function up(Table $table)
    {
        $table->string('users');
    }
}


class Table
{
    public $tables;

    public function string($str)
    {
        array_push($this->tables, $str);
    }

    public function timestamp()
    {
        $this->withTimestamp = true;
    }
}

class UC
{
    function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $stmt = self::prepare("INSERT INTO $tableName(". implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");
        
        foreach ($attributes as $attribute) {
            // $this->attr === public $email
            $stmt->bindValue(":$attribute", $this->$attribute);
        }

        return $stmt->execute();
    }
    public function tableName()
    {
      
    }    
    public function attributes()
    {
      return [];
    }    
    public static function prepare($s)
    {
       return (object) [];
    }
}
