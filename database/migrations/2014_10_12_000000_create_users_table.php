<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('mode')->default(0)->comment('0超级管理员');
            $table->integer('customerNum')->default(20)->comment('最大添加客服数据');
            $table->integer('nowCustomerNum')->default(0)->comment('现有客服数量');
            $table->enum('status',['active','forbidden','delete'])->default('active');
            $table->string('role_id',50)->nullable();
            $table->ipAddress('loginIp')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->enum('sex',['man','woman'])->default('man');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
