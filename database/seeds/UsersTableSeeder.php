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
            'name' => 'gsm1',
            'email' => 'gsm1@test.com',
            'password' => bcrypt('gsm1'),
        ]);

        factory('App\User')->create();
    }
}
