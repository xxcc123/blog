<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtisanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artisan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('关联用户id');
            $table->integer('comment_id')->default(0)->comment('关联评论id');
            $table->integer('category_id')->nullable()->comment('关联类别id');
            $table->string('title')->comment('标题');
            $table->string('label')->comment('标签');
            $table->longText('content')->comment('内容');
            $table->integer('state')->default(0)->comment('状态 0：待审核 1：发布 2：草稿 3：审核未通过');
            $table->integer('read_num')->default(0)->comment('阅读数');
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
        Schema::dropIfExists('artisan');
    }
}
