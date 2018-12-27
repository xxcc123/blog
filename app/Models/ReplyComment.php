<?php

namespace App\Models;

use App\Models\Backend\Comment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 回复评论模型
 * Class ReplyComment
 * @package App\Models
 * @property int user_id 关联用户id
 * @property string content 评论内容
 * @property int artisan_id 关联文章id
 * @property int comment_id 关联评论id
 */
class ReplyComment extends Model
{
    protected $table = 'reply_comment';

    protected $fillable = [
        'user_id',
        'content',
        'artisan_id',
        'comment_id'
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
