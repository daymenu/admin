<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pId')->default(1)->comment('父菜单ID');
            $table->string('pIds', 1000)->default('[]')->comment('父菜单ID路径');
            $table->string('name')->default('')->comment('接口名称');
            $table->string('route')->default('')->comment('路由');
            $table->string('url')->default('')->comment('接口地址');
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
        Schema::dropIfExists('api');
    }
}
