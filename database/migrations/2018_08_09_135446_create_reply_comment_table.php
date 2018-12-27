<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 回复评论表结构
 * Class CreateReplyCommentTable
 */
class CreateReplyCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artisan_id')->comment('关联文章id');
            $table->integer('user_id')->default(0)->comment('关联用户id');
            $table->integer('comment_id')->comment('关联评论id');
            $table->string('content')->nullable()->comment('评论内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply_comment');
    }
}
