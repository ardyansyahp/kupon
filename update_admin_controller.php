<?php
$file = 'c:/laragon/www/kupon/app/Http/Controllers/AdminController.php';
$content = file_get_contents($file);

$addMethods = '
    private function getActivePlant(Request $request)
    {
        if (Auth::user()->role === \'superadmin\') {
            return $request->query(\'plant_filter\', \'all\');
        }
        return Auth::user()->plant;
    }

    private function baseQuery($plant)
    {
        $query = Karyawan::query();
        if ($plant !== \'all\') {
            $query->where(\'plant\', $plant);
        }
        return $query;
    }
';

// Insert methods after class opening
$content = preg_replace('/class AdminController extends Controller\s*\{/', "class AdminController extends Controller\n{\n$addMethods", $content);

// Update index()
$content = preg_replace(
    '/public function index\(Request \$request\)\s*\{\s*\$plant = Auth::user\(\)->plant;/',
    'public function index(Request $request)
    {
        $activePlant = $this->getActivePlant($request);',
    $content
);
$content = str_replace(
    'Karyawan::where(\'plant\', $plant)',
    '$this->baseQuery($activePlant)',
    $content
);
$content = str_replace(
    'return view(\'admin.dashboard\', compact(',
    'return view(\'admin.dashboard\', compact(\'activePlant\', ',
    $content
);

// Update daftarTukar()
$content = preg_replace(
    '/public function daftarTukar\(Request \$request\)\s*\{\s*\$plant = Auth::user\(\)->plant;/',
    'public function daftarTukar(Request $request)
    {
        $activePlant = $this->getActivePlant($request);',
    $content
);
$content = str_replace(
    '$queryTunggu = Karyawan::where(\'plant\', $plant)->where(\'status_tukar\', \'menunggu\')->orderBy(\'waktu_tukar\', \'desc\');',
    '$queryTunggu = $this->baseQuery($activePlant)->where(\'status_tukar\', \'menunggu\')->orderBy(\'waktu_tukar\', \'desc\');',
    $content
);
$content = str_replace(
    '$queryRiwayat = Karyawan::where(\'plant\', $plant)->whereIn(\'status_tukar\', [\'sudah\', \'ditolak\'])->orderBy(\'waktu_konfirmasi\', \'desc\');',
    '$queryRiwayat = $this->baseQuery($activePlant)->whereIn(\'status_tukar\', [\'sudah\', \'ditolak\'])->orderBy(\'waktu_konfirmasi\', \'desc\');',
    $content
);
$content = str_replace(
    'return view(\'admin.daftar_tukar\', compact(\'daftarTunggu\', \'riwayat\'));',
    'return view(\'admin.daftar_tukar\', compact(\'daftarTunggu\', \'riwayat\', \'activePlant\'));',
    $content
);

// Update export()
$content = preg_replace(
    '/public function export\(\)\s*\{\s*\$plant = Auth::user\(\)->plant;/',
    'public function export(Request $request)
    {
        $activePlant = $this->getActivePlant($request);',
    $content
);
$content = str_replace(
    '$karyawan = Karyawan::where(\'plant\', $plant)->get();',
    '$karyawan = $this->baseQuery($activePlant)->get();',
    $content
);
$content = str_replace(
    '$filename = "rekap_qurban_plant_{$plant}_" . date(\'Y-m-d\') . ".xlsx";',
    '$filename = "rekap_qurban_plant_{$activePlant}_" . date(\'Y-m-d\') . ".xlsx";',
    $content
);

// Update listKaryawan()
$content = preg_replace(
    '/public function listKaryawan\(Request \$request\)\s*\{\s*\$plant = Auth::user\(\)->plant;/',
    'public function listKaryawan(Request $request)
    {
        $activePlant = $this->getActivePlant($request);',
    $content
);
$content = str_replace(
    '$query = Karyawan::where(\'plant\', $plant)->orderBy(\'nama\', \'asc\');',
    '$query = $this->baseQuery($activePlant)->orderBy(\'nama\', \'asc\');',
    $content
);
$content = str_replace(
    '$genderOptions = Karyawan::where(\'plant\', $plant)->whereNotNull',
    '$genderOptions = clone $this->baseQuery($activePlant)->whereNotNull',
    $content
);
$content = str_replace(
    '$statusOptions = Karyawan::where(\'plant\', $plant)->whereNotNull',
    '$statusOptions = clone $this->baseQuery($activePlant)->whereNotNull',
    $content
);
$content = str_replace(
    'return view(\'admin.list_karyawan\', compact(\'karyawans\', \'genderOptions\', \'statusOptions\'));',
    'return view(\'admin.list_karyawan\', compact(\'karyawans\', \'genderOptions\', \'statusOptions\', \'activePlant\'));',
    $content
);

file_put_contents($file, $content);
echo "AdminController updated.";
