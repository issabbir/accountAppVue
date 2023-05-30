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
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([ //,
            'name' => 'tanbir',
            'email' => 'atasiddiq@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
