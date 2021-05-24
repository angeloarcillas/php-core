<?php

namespace App\Models;

use Core\Blueprint\Models;

class User extends Models
{
    protected ?string $table = 'users';
    protected array $fillable = ['email', 'password'];
    protected string $key = 'id';

}