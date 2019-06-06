<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->char('username',50)->default(0)->comment('客服账号');
            $table->char('number',50)->default(0)->comment('客服号');
            $table->enum('status',['active', 'inactive','discard'])->default('active')->comment('账号状态');
            $table->char('password')->default(0);
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
        Schema::dropIfExists('customer');
    }
}
