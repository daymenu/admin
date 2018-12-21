<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_apis', function (Blueprint $table) {
            $table->integer('menu_id')->index()->default(0)->comment('菜单ID');
            $table->integer('api_id')->index()->default(0)->comment('apiID');
            $table->timestamps();
            $table->primary(['menu_id', 'api_id']);
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
        Schema::dropIfExists('menu_api');
    }
}
