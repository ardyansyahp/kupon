<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Plant 1',
            'username' => 'p1admin',
            'plant' => '1',
            'role' => 'admin',
            'password' => Hash::make('19841'),
        ]);

        User::create([
            'name' => 'Admin Plant 3',
            'username' => 'p3admin',
            'plant' => '3',
            'role' => 'admin',
            'password' => Hash::make('19843'),
        ]);

        User::create([
            'name' => 'Admin Plant 4',
            'username' => 'p4admin',
            'plant' => '4',
            'role' => 'admin',
            'password' => Hash::make('19844'),
        ]);
    }
}
