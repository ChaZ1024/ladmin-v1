<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * RBAC 角色节点表
 * Class CreateRoleNodeTable
 */
class CreateRoleNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_node', function (Blueprint $table) {
            $table->integer('role_id')->comment('角色id');
            $table->integer('node_id')->comment('节点id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_node');
    }
}
