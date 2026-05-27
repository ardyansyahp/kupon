<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('karyawans')
            ->where('jeniskelamin', 'M')
            ->update(['jeniskelamin' => 'L']);

        DB::table('karyawans')
            ->where('jeniskelamin', 'F')
            ->update(['jeniskelamin' => 'P']);
    }
}
