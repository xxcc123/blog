<?php

namespace App\Models;

use App\Models\Backend\Artisan;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 类别模型
 * Class Category
 * @package App\Models
 * @property int user_id 关联用户id
 * @property string category_name 分类名
 */
class Category extends Model
{
    protected $perPage = 10;

    protected $table = 'category';

    protected $fillable = [
        'user_id',
        'category_name',
    ];

    public function artisans()
    {
        return $this->hasMany(Artisan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
