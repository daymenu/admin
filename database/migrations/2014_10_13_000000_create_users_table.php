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
            $table->increments('id');
            $table->string('nick_name')->default('')->comment('昵称');
            $table->string('user_name')->default('')->comment('用户名');
            $table->string('name')->default('')->comment('姓名');
            $table->string('email')->unique()->comment('邮箱号');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('')->comment('密码');
            $table->text('avatar')->default('')->comment('头像');
            $table->tinyInteger('status')->default(1)->comment('状态 1 正常 2 禁用');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
