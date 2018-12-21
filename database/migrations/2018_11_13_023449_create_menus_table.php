<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('路由名称');
            $table->string('path')->default('')->comment('路由地址');
            $table->string('title')->default('')->comment('路由标题');
            $table->string('icon')->default('')->comment('菜单图标名称');
            $table->string('redirect')->default('')->comment('重定向路由');
            $table->integer('pId')->default(1)->comment('父菜单ID');
            $table->string('pIds', 1000)->default('[]')->comment('父菜单ID路径');
            $table->tinyInteger('type')->default(1)->comment('菜单类别 1 菜单 2 按钮');
            $table->tinyInteger('always_show')->default(1)->comment('菜单置顶 1 是 2 否');
            $table->tinyInteger('hidden')->default(1)->comment('菜单隐藏 1 是 2 否');
            $table->integer('sort')->default(0)->comment('菜单排序');
            $table->tinyInteger('status')->default(1)->comment('状态 1 正常 2 禁用');
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
        Schema::dropIfExists('menu');
    }
}
