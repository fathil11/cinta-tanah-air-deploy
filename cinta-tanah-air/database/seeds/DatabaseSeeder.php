<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@cta.com',
            'password' => bcrypt('123123123'),
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Author',
            'email' => 'author@cta.com',
            'password' => bcrypt('123123123'),
        ]);
    }
}
