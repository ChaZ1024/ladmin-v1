<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'account' => 'admin',
            'email' => '328103224@qq.com',
            'password' => bcrypt('admin'),
            'phone'=>'18018260611',
        ]);
    }
}
