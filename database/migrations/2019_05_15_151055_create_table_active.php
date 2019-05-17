<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_active', function (Blueprint $table) {
            $table->increments('id')->index('id');
            $table->integer('cid')->index('cid')->comment('分类外键');
            $table->string('category')->comment('分类名称');
            $table->string('title')->comment('文章标题');
            $table->string('description',1000)->comment('文章详情');
            $table->text('content')->comment('文章内容');
            $table->timestamp('createTime')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ma_active');
    }
}
