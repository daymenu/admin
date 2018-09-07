<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdminAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->default('')->comment('名字');
            $table->string('user_name')->index()->default('')->comment('用户名');
            $table->string('email')->index()->default('')->comment('邮箱号');
            $table->string('password')->default('')->comment('密码');
            $table->integer('status')->default(1)->comment('状态 1 正常 2 禁用');
            $table->integer('password_errors')->default(1)->comment('密码错误次数');
            $table->string('ip')->default('')->comment('最后一次登录IP');
            $table->string('login_time')->default('')->comment('最后一次登录时间');
            $table->integer('create_id')->default(0)->comment('创建者');
            $table->integer('update_id')->default(0)->comment('更新者');
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
        Schema::dropIfExists('admin_admin');
    }
}
