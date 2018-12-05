<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniappConfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miniapp_conf', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->comment('配置key');
            $table->string('value')->comment('配置值');
            $table->string('sort')->default(0)->comment('配置值排序');
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
        Schema::dropIfExists('miniapp_conf');
    }
}
