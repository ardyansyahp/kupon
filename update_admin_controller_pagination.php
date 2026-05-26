<?php
$adminFile = 'c:/laragon/www/kupon/app/Http/Controllers/AdminController.php';
$content = file_get_contents($adminFile);

// Index
$content = str_replace(
    'public function index(Request $request)
    {
        $activePlant = $this->getActivePlant($request);',
    'public function index(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $perPageDashboard = $request->input(\'per_page\', 5);',
    $content
);
$content = str_replace(
    'return view(\'admin.dashboard\', compact(\'activePlant\', 
            \'totalKaryawan\', \'menunggu\', \'sudahDitukar\', \'belumDitukar\'
        ));',
    '$terakhir = $this->baseQuery($activePlant)
            ->where(\'status_tukar\', \'sudah\')
            ->orderBy(\'waktu_tukar\', \'desc\')
            ->paginate($perPageDashboard, [\'*\'], \'dashboard_page\')
            ->appends($request->all());
        
        return view(\'admin.dashboard\', compact(\'activePlant\', 
            \'totalKaryawan\', \'menunggu\', \'sudahDitukar\', \'belumDitukar\', \'terakhir\'
        ));',
    $content
);

// Daftar Tukar
$content = preg_replace(
    '/public function daftarTukar\(Request \$request\)\s*\{\s*\$activePlant = \$this->getActivePlant\(\$request\);/',
    'public function daftarTukar(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $perPageTunggu = $request->input(\'per_page_tunggu\', 10);
        $perPageRiwayat = $request->input(\'per_page_riwayat\', 10);',
    $content
);
$content = str_replace(
    '$daftarTunggu = $queryTunggu->paginate(10, [\'*\'], \'tunggu_page\');',
    '$daftarTunggu = $queryTunggu->paginate($perPageTunggu, [\'*\'], \'tunggu_page\')->appends($request->all());',
    $content
);
$content = str_replace(
    '$riwayat = $queryRiwayat->paginate(10, [\'*\'], \'riwayat_page\');',
    '$riwayat = $queryRiwayat->paginate($perPageRiwayat, [\'*\'], \'riwayat_page\')->appends($request->all());',
    $content
);

// List Karyawan
$content = preg_replace(
    '/public function listKaryawan\(Request \$request\)\s*\{\s*\$activePlant = \$this->getActivePlant\(\$request\);/',
    'public function listKaryawan(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $perPage = $request->input(\'per_page\', 15);',
    $content
);
$content = str_replace(
    '$karyawans = $query->paginate(15);',
    '$karyawans = $query->paginate($perPage)->appends($request->all());',
    $content
);

file_put_contents($adminFile, $content);
echo "AdminController updated.";
