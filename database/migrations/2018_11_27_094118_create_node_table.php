<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * RBAC节点表
 * Class CreateNodeTable
 */
class CreateNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('节点名称');
            $table->string('etitle')->comment('英文节点名称');
            $table->string('icon')->default('')->comment('icon图标');
            $table->string('router')->comment('节点路由');
            $table->tinyInteger('status')->default(1)->comment('是否显示 0为不显示，1为显示');
            $table->integer('pid')->comment('父级节点');
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
        Schema::dropIfExists('node');
    }
}
