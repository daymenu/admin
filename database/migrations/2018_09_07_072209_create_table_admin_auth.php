<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdminAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->default('')->comment('菜单名字');
            $table->string('icon')->default('')->comment('菜单图标');
            $table->string('route')->index()->default('')->comment('路有名字');
            $table->integer('pId')->default(0)->comment('父菜单');
            $table->integer('show')->default(0)->comment('是否显示');
            $table->integer('order_by')->default(0)->comment('排序');
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
        Schema::dropIfExists('admin_auth');
    }
}
