<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_category', function (Blueprint $table) {
            $table->increments('id')->index('id');
            $table->string('title',100)->comment('分类名称');
            $table->integer('pid')->default(0)->comment('分类等级');
            $table->string('path')->default(0)->comment('分类路径');
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
        Schema::dropIfExists('ma_category');
    }
}
