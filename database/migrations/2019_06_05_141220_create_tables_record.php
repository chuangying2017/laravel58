<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->index('customer_id')->comment('关联客服id');
            $table->char('client_number')->comment('客户号');
            $table->enum('type',['msg', 'image'])->default('msg')->comment('内容类型');
            $table->string('content',1000)->default(0)->comment('会话内容 msg or image');
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
        Schema::dropIfExists('session_record');
    }
}
