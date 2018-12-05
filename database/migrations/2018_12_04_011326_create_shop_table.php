<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('商户名称');
            $table->string('discription')->comment('商户介绍');
            $table->string('pic')->default('')->comment('商户图片');
            $table->string('address')->comment('商户地址');
            $table->string('phone')->comment('商户电话');
            $table->string('lat')->comment('商户经度');
            $table->string('lon')->comment('商户纬度');
            $table->string('sort')->default(0)->comment('排序');
            $table->string('status')->default(1)->comment('商户状态 1为正常  0为封禁');
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
        Schema::dropIfExists('shop');
    }
}
