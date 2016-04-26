<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(\App\User::class,100)->create();
        factory(\App\Discussion::class,800)->create();
        factory(\App\Comment::class,1200)->create();

    }
}
