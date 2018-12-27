<?php

namespace App\Models\Backend;

use App\Models\Category;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Label;

/**
 * 文章模型
 * Class Artisan
 * @package App\Models\Backend
 * @params int user_id 关联用户id
 * @params int comment_id 关联评论id
 * @params int category_id 关联类别id
 * @params string title 标题
 * @params string label 标签
 * @params longtext content 内容
 * @params int state 状态  0：待审核 1：发布 2：草稿 3：审核未通过
 */
class Artisan extends Model
{
    use Label;
    protected $perPage = 10;

    protected  $table = 'artisan';

    protected $fillable = [
        'user_id',
        'comment_id',
        'category_id',
        'title',
        'label',
        'content',
        'state',
        'read_num'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'artisan_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
