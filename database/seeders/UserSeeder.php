<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create ([
            'name' => 'Administrator',
            'email' => 'admin@kedai.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '082172897335',
            'address' => 'JL.Sekolah',
            'status' => 'active',
        ]);
    }
}
