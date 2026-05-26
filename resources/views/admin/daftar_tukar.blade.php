@extends('layouts.admin')

@section('content')
<div class="fade-in space-y-6 max-w-full">

    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Daftar Tukar Kupon</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Daftar Tukar Kupon</p>
        </div>

        @if(Auth::user()->role === 'superadmin')
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
            @foreach(request()->except('plant_filter', 'page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <select name="plant_filter" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 font-semibold shadow-sm cursor-pointer">
                <option value="all" {{ (request('plant_filter') ?? 'all') == 'all' ? 'selected' : '' }}>Semua Plant</option>
                <option value="1" {{ request('plant_filter') == '1' ? 'selected' : '' }}>Plant 1</option>
                <option value="3" {{ request('plant_filter') == '3' ? 'selected' : '' }}>Plant 3</option>
                <option value="4" {{ request('plant_filter') == '4' ? 'selected' : '' }}>Plant 4</option>
            </select>
        </form>
        @endif
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-[6px] shadow-sm flex justify-between items-center transition-all duration-300">
            <span class="font-bold text-xs">{{ session('success') }}</span>
            <button @click="show = false" class="text-base font-bold leading-none">&times;</button>
        </div>
    @endif

    {{-- Interactive Waiting List & History Section --}}
    <div class="space-y-6">
        
        {{-- Section: Daftar Menunggu Konfirmasi --}}
        <div class="bg-white rounded-[6px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-gray-50/50">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900">Daftar Tukar Kupon (Menunggu Konfirmasi)</h3>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5">Silakan lakukan persetujuan atau penolakan kupon di sini.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('admin.daftar-tukar') }}" class="flex items-center gap-2">
                        @foreach(request()->except('per_page_tunggu', 'tunggu_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Tampilkan:</span>
                        <select name="per_page_tunggu" onchange="this.form.submit()" class="px-2 py-1.5 text-xs border border-gray-200 rounded-[6px] focus:ring-2 focus:ring-emerald-500 outline-none bg-white shadow-inner font-bold cursor-pointer">
                            <option value="10" {{ request('per_page_tunggu') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page_tunggu') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page_tunggu') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page_tunggu') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>

                    <form class="flex gap-2 w-full sm:w-auto" method="GET" action="{{ route('admin.daftar-tukar') }}">
                        @foreach(request()->except('search_tunggu', 'tunggu_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="text" name="search_tunggu" value="{{ request('search_tunggu') }}" placeholder="Cari nama atau NIK..." class="px-3.5 py-1.5 text-xs border border-gray-200 rounded-[6px] focus:ring-2 focus:ring-emerald-500 outline-none w-full sm:w-56 bg-white shadow-inner">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-[6px] text-xs font-bold transition-colors shadow-sm">Cari</button>
                    </form>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 text-[9px] uppercase font-bold tracking-wider">
                            <th class="px-5 py-3 border-b border-gray-200">Nama Karyawan</th>
                            <th class="px-5 py-3 border-b border-gray-200">NIK</th>
                            <th class="px-5 py-3 border-b border-gray-200">JK</th>
                            <th class="px-5 py-3 border-b border-gray-200">Status</th>
                            <th class="px-5 py-3 border-b border-gray-200 text-center">Qty</th>
                            <th class="px-5 py-3 border-b border-gray-200">Departemen</th>
                            <th class="px-5 py-3 border-b border-gray-200">Waktu Tukar</th>
                            <th class="px-5 py-3 border-b border-gray-200 text-center whitespace-nowrap">Status Tukar</th>
                            <th class="px-5 py-3 border-b border-gray-200 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($daftarTunggu as $item)
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-5 py-3 font-bold text-gray-900">{{ $item->nama }}</td>
                                <td class="px-5 py-3 text-xs font-bold text-gray-500">{{ $item->nik }}</td>
                                <td class="px-5 py-3 text-xs font-bold text-gray-400">{{ $item->jeniskelamin ?? '-' }}</td>
                                <td class="px-5 py-3 text-xs font-bold text-gray-400">{{ $item->status ?? '-' }}</td>
                                <td class="px-5 py-3 text-xs font-bold text-gray-900 text-center">{{ $item->qty_ambil ?? 1 }}</td>
                                <td class="px-5 py-3 text-xs font-bold text-gray-500">{{ $item->departemen }}</td>
                                <td class="px-5 py-3 text-xs text-gray-400 font-bold">{{ \Carbon\Carbon::parse($item->waktu_tukar)->format('d M Y - H:i') }} WIB</td>
                                <td class="px-5 py-3 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-amber-50 text-amber-700 border border-amber-200/50">
                                        Menunggu Konfirmasi
                                    </span>
                                </td>
                                <td class="px-5 py-3 align-middle text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2 shrink-0">
                                    <form method="POST" action="{{ route('admin.accept', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-[6px] text-[10px] font-extrabold transition-all flex items-center gap-1 border border-emerald-100 shadow-sm">
                                            <i class="fa-solid fa-check"></i>
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.reject', $item->id) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tolak kupon ini?')" class="bg-red-50 hover:bg-red-100 text-red-700 px-2.5 py-1 rounded-[6px] text-[10px] font-extrabold transition-all flex items-center gap-1 border border-red-100 shadow-sm">
                                            <i class="fa-solid fa-xmark"></i>
                                            Tolak
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-6 text-center text-gray-400 font-semibold">Tidak ada data yang menunggu konfirmasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/20 flex justify-end">
                {{ $daftarTunggu->appends(request()->query())->links('vendor.pagination.custom-link') }}
            </div>
        </div>

        {{-- Section: Riwayat Penukaran --}}
        <div class="bg-white rounded-[6px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-gray-50/50">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900">Riwayat Tukar Kupon (Sudah Ditukar / Ditolak)</h3>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5">Daftar kupon qurban yang telah Anda konfirmasi atau tolak.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('admin.daftar-tukar') }}" class="flex items-center gap-2">
                        @foreach(request()->except('per_page_riwayat', 'riwayat_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Tampilkan:</span>
                        <select name="per_page_riwayat" onchange="this.form.submit()" class="px-2 py-1.5 text-xs border border-gray-200 rounded-[6px] focus:ring-2 focus:ring-emerald-500 outline-none bg-white shadow-inner font-bold cursor-pointer">
                            <option value="10" {{ request('per_page_riwayat') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page_riwayat') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page_riwayat') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page_riwayat') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>

                    <form class="flex gap-2 w-full sm:w-auto" method="GET" action="{{ route('admin.daftar-tukar') }}">
                        @foreach(request()->except('search_riwayat', 'riwayat_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="text" name="search_riwayat" value="{{ request('search_riwayat') }}" placeholder="Cari nama atau NIK..." class="px-3.5 py-1.5 text-xs border border-gray-200 rounded-[6px] focus:ring-2 focus:ring-emerald-500 outline-none w-full sm:w-56 bg-white shadow-inner">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-[6px] text-xs font-bold transition-colors shadow-sm">Cari</button>
                    </form>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 text-[9px] uppercase font-bold tracking-wider">
                            <th class="px-6 py-3 border-b border-gray-200">Nama Karyawan</th>
                            <th class="px-6 py-3 border-b border-gray-200">NIK</th>
                            <th class="px-6 py-3 border-b border-gray-200">JK</th>
                            <th class="px-6 py-3 border-b border-gray-200">Status</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center">Qty</th>
                            <th class="px-6 py-3 border-b border-gray-200">Waktu Tukar</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center whitespace-nowrap">Status Tukar</th>
                            <th class="px-6 py-3 border-b border-gray-200">Waktu Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($riwayat as $item)
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-3 font-bold text-gray-900">{{ $item->nama }}</td>
                                <td class="px-6 py-3 text-xs font-bold text-gray-500">{{ $item->nik }}</td>
                                <td class="px-6 py-3 text-xs font-bold text-gray-400">{{ $item->jeniskelamin ?? '-' }}</td>
                                <td class="px-6 py-3 text-xs font-bold text-gray-400">{{ $item->status ?? '-' }}</td>
                                <td class="px-6 py-3 text-xs font-bold text-gray-900 text-center">{{ $item->qty_ambil ?? 1 }}</td>
                                <td class="px-6 py-3 text-xs text-gray-400 font-bold">{{ \Carbon\Carbon::parse($item->waktu_tukar)->format('d M Y - H:i') }} WIB</td>
                                <td class="px-6 py-3 text-center whitespace-nowrap">
                                    @if($item->status_tukar == 'sudah')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                            Sudah Ditukar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-red-50 text-red-700 border border-red-200/50">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-xs text-gray-400 font-bold">{{ \Carbon\Carbon::parse($item->waktu_konfirmasi)->format('d M Y - H:i') }} WIB</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-6 text-center text-gray-400 font-semibold">Tidak ada riwayat pertukaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/20 flex justify-end">
                {{ $riwayat->appends(request()->query())->links('vendor.pagination.custom-link') }}
            </div>
        </div>

    </div>

</div>
@endsection
