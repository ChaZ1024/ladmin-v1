<?php

use Illuminate\Database\Seeder;

class SysconfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_config')->insert([
            'title' => '系统名称',
            'key' => 'SYS_TITLE',
            'value' => '大象净化器',
        ]);
    }
}
