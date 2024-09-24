<?php


// use Illuminate\Contracts\Auth\MustVerifyEmail;

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    // Other attributes and methods of the User model
}
