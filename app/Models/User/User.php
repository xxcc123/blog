<?php

namespace App\Models\User;

use App\Models\Backend\Artisan;
use App\Models\Backend\Comment;
use App\Models\Category;
use App\Models\ReplyComment;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models\User
 * @package  string name 用户名
 * @property string email 邮箱
 * @property string password 密码
 * @property boolean is_admin 是否是管理员
 * @property string img 图片地址
 */
class User extends Model
{
    protected $fillable= ['name','email','password','remember_token','img','is_admin'];

    public function artisans()
    {
        return $this->hasMany(Artisan::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categorys()
    {
        return $this->hasMany(Category::class);
    }

    public function reply_comment()
    {
        return $this->hasMany(ReplyComment::class);
    }

}
