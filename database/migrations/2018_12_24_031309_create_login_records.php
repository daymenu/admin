<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adminId')->default(0)->comment('登录ID');
            $table->bigInteger('ip')->default(0)->comment('ip');
            $table->string('address')->default('')->comment('登录地');
            $table->tinyInteger('status')->default(1)->comment('状态 1 成功 2 失败');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_records');
    }
}
