<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * rbac 角色表
 * Class CreateRoleTable
 */
class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('角色名称');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('super')->default(0)->comment('是否为超级管理员');
            $table->tinyInteger('status')->default(1)->comment('角色状态,1为正常，0为禁用');
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
        Schema::dropIfExists('role');
    }
}
