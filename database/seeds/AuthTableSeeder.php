<?php

use Illuminate\Database\Seeder;

class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_id=DB::table('role')->insertGetId([
            'title' => '超级管理员',
            'super' => 1,
        ]);
        $adminData=DB::table('admins')->where('account','admin')->first();

        DB::table('admin_role')->insertGetId([
            'role_id' => $role_id,
            'admin_id'=>$adminData->id,
        ]);

    }
}
