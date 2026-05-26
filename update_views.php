<?php
$dashboard = 'c:/laragon/www/kupon/resources/views/admin/dashboard.blade.php';
$content = file_get_contents($dashboard);

// Update Auth::user()->plant to $activePlant
$content = str_replace("Auth::user()->plant", "\$activePlant", $content);

// In queries, if activePlant === 'all', we shouldn't use where('plant', $activePlant).
// Replace \App\Models\Karyawan::where('plant', $activePlant) with
// \App\Models\Karyawan::when($activePlant !== 'all', fn($q) => $q->where('plant', $activePlant))

$content = str_replace(
    "\App\Models\Karyawan::where('plant', \$activePlant)",
    "\App\Models\Karyawan::when(\$activePlant !== 'all', fn(\$q) => \$q->where('plant', \$activePlant))",
    $content
);

file_put_contents($dashboard, $content);

$filesWithFilter = [
    'c:/laragon/www/kupon/resources/views/admin/list_karyawan.blade.php',
    'c:/laragon/www/kupon/resources/views/admin/daftar_tukar.blade.php',
];

$filterHtml = '
    @if(Auth::user()->role === \'superadmin\')
    <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mr-2">
        @foreach(request()->except(\'plant_filter\', \'page\') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="plant_filter" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 font-semibold shadow-sm">
            <option value="all" {{ (request(\'plant_filter\') ?? \'all\') == \'all\' ? \'selected\' : \'\' }}>Semua Plant</option>
            <option value="1" {{ request(\'plant_filter\') == \'1\' ? \'selected\' : \'\' }}>Plant 1</option>
            <option value="3" {{ request(\'plant_filter\') == \'3\' ? \'selected\' : \'\' }}>Plant 3</option>
            <option value="4" {{ request(\'plant_filter\') == \'4\' ? \'selected\' : \'\' }}>Plant 4</option>
        </select>
    </form>
    @endif
';

foreach ($filesWithFilter as $file) {
    $c = file_get_contents($file);
    // Find the right place to inject the filter.
    // For list_karyawan, there is a search form. We can put it next to the search input, or at the top header.
    // I will just put it in the filter area.
    
    // Actually, I can just do a regex replace to insert the filter form.
    // Look for <div class="flex items-center gap-4"> or similar.
    // Just inject it after the title or header page.
    $c = preg_replace(
        '/(<h2 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">.*?<\/h2>)/s',
        "$1\n$filterHtml",
        $c
    );
    file_put_contents($file, $c);
}

echo "Views updated.";
