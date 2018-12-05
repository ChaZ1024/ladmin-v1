<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account',20)->comment('管理员账号');
            $table->string('password',80)->comment('管理员密码');
            $table->string('phone',20)->comment('管理员手机号码');
            $table->string('email',100)->comment('管理员邮箱');
            $table->tinyInteger('super')->default(0)->comment('是否为超级管理员');
            $table->string('avatar',100)->default('')->comment('管理员头像');
            $table->smallInteger('status')->default(1)->comment('管理员状态　１为正常，０为禁用');
            $table->string('last_ip')->default('')->comment('最后登录ＩＰ');
            $table->dateTime('last_time')->default(date('Y-m-d H:i:s'))->comment('最后登录时间');
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
        Schema::dropIfExists('admins');
    }
}
