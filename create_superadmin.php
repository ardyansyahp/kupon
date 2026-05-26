<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\User::updateOrCreate(
    ['username' => 'superadmin'],
    [
        'name' => 'Super Admin',
        'password' => bcrypt('2025'),
        'role' => 'superadmin',
        'plant' => 'all'
    ]
);
echo 'Superadmin created.';
