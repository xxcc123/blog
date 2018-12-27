<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    protected $hidden= ['password','remember_token'];

    protected $fillable= ['name','email','password'];
}
