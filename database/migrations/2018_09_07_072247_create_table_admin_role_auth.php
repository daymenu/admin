<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdminRoleAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->default(0)->comment('角色ID');
            $table->integer('auth_id')->default(0)->comment('权限ID');
            $table->integer('is_Del')->default(0)->comment('是否删除');
            $table->integer('create_id')->default(0)->comment('创建者');
            $table->integer('update_id')->default(0)->comment('更新者');
            $table->integer('delete_id')->default(0)->comment('删除者');
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
        Schema::dropIfExists('admin_role_auth');
    }
}
