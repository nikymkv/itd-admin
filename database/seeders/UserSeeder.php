<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

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
            'name' => 'itd',
            'email' => 'itdwebcompany@gmail.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('0000'),
            'remember_token' => \Str::random(10),
        ]);
    }
}
