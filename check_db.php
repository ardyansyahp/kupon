<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = \App\Models\Karyawan::take(10)->get(['id', 'nama', 'plant', 'nik']);
foreach($data as $d) {
    echo "ID: {$d->id}, NIK: {$d->nik}, Nama: {$d->nama}, Plant: '{$d->plant}'\n";
}
