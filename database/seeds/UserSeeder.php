<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Admin',
            'email' => 'root@root.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Senha definida como 'password'
            'remember_token' => Str::random(60),
        ]);
    }
}
