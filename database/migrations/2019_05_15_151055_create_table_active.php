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
            $table->integer('category_id')->index('category_id')->comment('分类外键');
            $table->string('title')->comment('文章标题');
            $table->string('description')->comment('文章详情');
            $table->string('content')->comment('文章内容');
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
        Schema::dropIfExists('ma_active');
    }
}
