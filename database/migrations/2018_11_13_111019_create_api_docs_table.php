<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_id')->default(0)->comment('api ID');
            $table->mediumText('text')->default('')->comment('接口内容');
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
        Schema::dropIfExists('api_doc');
    }
}
