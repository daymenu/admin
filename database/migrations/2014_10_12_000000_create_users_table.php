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
            $table->string('name')->default('')->comment('姓名');
            $table->string('email')->unique()->comment('邮箱号');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('')->comment('密码');
            $table->string('provider')->default('')->comment('第三方');
            $table->string('provider_id')->default('')->comment('第三方用户ID');
            $table->text('avatar')->default('')->comment('头像');
            $table->ingter('status')->default(0)->comment('状态 0 正常 1 禁用');
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
