<?php

namespace App\Models;

use \Zeretei\PHPCore\Blueprint\Model;

class User extends Model
{
    protected array $fillable = ['username', 'email'];
}
