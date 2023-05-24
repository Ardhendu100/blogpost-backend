<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
class Registration extends Model
{
    use HasFactory;
    use HasApiTokens;
    public $table = "users";

}
