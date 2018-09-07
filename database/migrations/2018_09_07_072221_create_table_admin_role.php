<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->default('')->comment('名字');
            $table->string('remark')->default('')->comment('备注');
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
        Schema::dropIfExists('admin_role');
    }
}
