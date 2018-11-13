<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => '韩剑',
            'nick_name' => '小贱贱',
            'email' => 'hanjian2018@126.com',
            'password' => Hash::make('123456'),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            
        ]);
    }
}
