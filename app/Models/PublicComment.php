<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicComment extends Model
{
    use HasFactory;
    protected $fillable = ['text','user_id','post_id','avatar','email','name'];
}
