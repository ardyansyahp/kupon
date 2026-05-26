<?php

function getPaginationHtml($paginatorVar, $perPageParam) {
    return '
        {{-- Pagination & Rows Per Page --}}
        <div class="bg-white px-5 py-4 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 text-xs font-semibold text-gray-500 order-2 md:order-1">
                <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 m-0">
                    @foreach(request()->except([\'' . $perPageParam . '\', \'' . $paginatorVar . '_page\']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <span>Tampilkan</span>
                    <select name="' . $perPageParam . '" onchange="this.form.submit()" class="px-2 py-1 border border-gray-200 rounded-[4px] focus:outline-none focus:ring-1 focus:ring-emerald-500 bg-gray-50 text-xs font-bold text-gray-700 cursor-pointer">
                        <option value="10" {{ request(\'' . $perPageParam . '\') == \'10\' ? \'selected\' : \'\' }}>10</option>
                        <option value="25" {{ request(\'' . $perPageParam . '\') == \'25\' ? \'selected\' : \'\' }}>25</option>
                        <option value="50" {{ request(\'' . $perPageParam . '\') == \'50\' ? \'selected\' : \'\' }}>50</option>
                        <option value="100" {{ request(\'' . $perPageParam . '\') == \'100\' ? \'selected\' : \'\' }}>100</option>
                    </select>
                    <span>data</span>
                </form>
                <div class="border-l border-gray-300 h-4 mx-1"></div>
                <div>
                    Menampilkan <span class="font-extrabold text-gray-900">{{ $' . $paginatorVar . '->firstItem() ?? 0 }}</span>
                    - <span class="font-extrabold text-gray-900">{{ $' . $paginatorVar . '->lastItem() ?? 0 }}</span>
                    dari <span class="font-extrabold text-gray-900">{{ $' . $paginatorVar . '->total() }}</span>
                </div>
            </div>
            <div class="order-1 md:order-2">
                {{ $' . $paginatorVar . '->appends(request()->query())->links(\'vendor.pagination.custom-link\') }}
            </div>
        </div>
';
}

// 1. Update list_karyawan.blade.php
$file = 'c:/laragon/www/kupon/resources/views/admin/list_karyawan.blade.php';
$content = file_get_contents($file);
$content = preg_replace(
    '/\{\{-- Pagination --\}\}\s*@if\(\$karyawans->hasPages\(\)\).*?@endif/s',
    getPaginationHtml('karyawans', 'per_page'),
    $content
);
file_put_contents($file, $content);

// 2. Update daftar_tukar.blade.php
$file = 'c:/laragon/www/kupon/resources/views/admin/daftar_tukar.blade.php';
$content = file_get_contents($file);
// Replace Tunggu
$content = preg_replace(
    '/\{\{-- Pagination --\}\}\s*@if\(\$daftarTunggu->hasPages\(\)\).*?@endif/s',
    getPaginationHtml('daftarTunggu', 'per_page_tunggu'),
    $content
);
// Replace Riwayat
$content = preg_replace(
    '/\{\{-- Pagination Riwayat --\}\}\s*@if\(\$riwayat->hasPages\(\)\).*?@endif/s',
    getPaginationHtml('riwayat', 'per_page_riwayat'),
    $content
);
file_put_contents($file, $content);

// 3. Update dashboard.blade.php
$file = 'c:/laragon/www/kupon/resources/views/admin/dashboard.blade.php';
$content = file_get_contents($file);
// In dashboard, it wasn't paginated before. The code was:
/*
<table class="w-full text-left text-xs border-collapse">
...
</table>
</div>
*/
// Find where it ends and replace it
$paginationHtml = getPaginationHtml('terakhir', 'per_page');
$content = preg_replace(
    '/(<td colspan="5" class="py-8 text-center text-gray-400 font-bold">Belum ada riwayat penukaran\.<\/td>\s*<\/tr>\s*@endforelse\s*<\/tbody>\s*<\/table>\s*<\/div>)/s',
    "$1\n$paginationHtml",
    $content
);
file_put_contents($file, $content);

echo "Views updated with custom pagination.";
