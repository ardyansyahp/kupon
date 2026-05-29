<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddTimezoneOffsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update karyawans table
        DB::table('karyawans')->update([
            'waktu_tukar' => DB::raw('DATE_ADD(waktu_tukar, INTERVAL 7 HOUR)'),
            'waktu_konfirmasi' => DB::raw('DATE_ADD(waktu_konfirmasi, INTERVAL 7 HOUR)'),
            'created_at' => DB::raw('DATE_ADD(created_at, INTERVAL 7 HOUR)'),
            'updated_at' => DB::raw('DATE_ADD(updated_at, INTERVAL 7 HOUR)')
        ]);

        // Update users table
        DB::table('users')->update([
            'created_at' => DB::raw('DATE_ADD(created_at, INTERVAL 7 HOUR)'),
            'updated_at' => DB::raw('DATE_ADD(updated_at, INTERVAL 7 HOUR)')
        ]);
    }
}
