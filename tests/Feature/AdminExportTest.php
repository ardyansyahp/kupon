<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_export_xlsx_without_errors(): void
    {
        // 1. Create a dummy admin user by setting attributes directly to bypass fillable guard
        $admin = new User();
        $admin->name = 'Plant 1 Admin';
        $admin->username = 'p1admin';
        $admin->password = bcrypt('password');
        $admin->plant = '1';
        $admin->role = 'admin';
        $admin->save();

        // 2. Create some dummy karyawan data
        Karyawan::create([
            'nik' => '12345678',
            'nama' => 'Budi Santoso',
            'departemen' => 'Produksi',
            'plant' => '1',
            'jeniskelamin' => 'Laki-laki',
            'status' => 'Karyawan Tetap',
            'status_tukar' => 'belum',
        ]);

        Karyawan::create([
            'nik' => '87654321',
            'nama' => 'Siti Aminah',
            'departemen' => 'HRD',
            'plant' => '1',
            'jeniskelamin' => 'Perempuan',
            'status' => 'Kontrak',
            'status_tukar' => 'sudah',
            'waktu_tukar' => now(),
            'waktu_konfirmasi' => now(),
        ]);

        // We capture output using ob_start since the controller calls exit;
        ob_start();
        $response = $this->actingAs($admin)->get(route('admin.export'));
        $output = ob_get_clean();

        // Assert response headers
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->assertStringContainsString('rekap_qurban_plant_1_', $response->headers->get('Content-Disposition'));
    }
}
