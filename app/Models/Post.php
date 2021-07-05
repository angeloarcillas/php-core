<?php

namespace App\Models;

use \Zeretei\PHPCore\Blueprint\Model;

class Post extends Model
{
    protected array $fillable = ['user_id','title', 'body'];
}
