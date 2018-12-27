<?php

namespace App\Models\Backend;

use App\Models\ReplyComment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App\Models\Backend
 * @property int user_id 关联用户id
 * @property int artisan_id 关联文章id
 * @property string content 评论内容
 */
class Comment extends Model
{
    protected  $table = 'comment';

    protected $fillable = [
        'user_id',
        'content',
        'artisan_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class,'id','artisan_id');
    }

    public function reply_comments()
    {
        return $this->hasMany(ReplyComment::class);
    }
}
