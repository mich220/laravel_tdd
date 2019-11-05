<?php

use App\User;
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
       User::create([
           'name' => 'user',
           'email' => 'user@mail.com',
           'email_verified_at' => now(),
           'password' => bcrypt('test123'), // secret
           'remember_token' => 'xd',
       ]);
        // $this->call(UsersTableSeeder::class);
    }
}
