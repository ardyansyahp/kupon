@extends('layouts.admin')

@section('content')
<div x-data="{ 
    showEditModal: false, 
    activeKaryawan: { id: '', nik: '', nama: '', departemen: '', jeniskelamin: '', status: '' } 
}" 
x-init="$watch('showEditModal', val => document.body.style.overflow = val ? 'hidden' : '')"
@keydown.window.escape="showEditModal = false"
class="max-w-full relative">

    <div class="fade-in space-y-6">

    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Semua Karyawan</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Karyawan &rsaquo; Manajemen Data</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
            @if(Auth::user()->role === 'superadmin')
            <form method="GET" action="{{ url()->current() }}" class="flex items-center w-full sm:w-auto">
                @foreach(request()->except('plant_filter', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select name="plant_filter" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 font-semibold shadow-sm cursor-pointer">
                    <option value="all" {{ (request('plant_filter') ?? 'all') == 'all' ? 'selected' : '' }}>Semua Plant</option>
                    <option value="1" {{ request('plant_filter') == '1' ? 'selected' : '' }}>Plant 1</option>
                    <option value="3" {{ request('plant_filter') == '3' ? 'selected' : '' }}>Plant 3</option>
                    <option value="4" {{ request('plant_filter') == '4' ? 'selected' : '' }}>Plant 4</option>
                </select>
            </form>
            @endif
            
            {{-- Quick Actions --}}
            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <a href="{{ route('admin.import') }}" class="flex-1 sm:flex-initial bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-2 rounded-[6px] text-xs font-bold transition-all border border-emerald-100 shadow-sm flex items-center justify-center gap-1.5 uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Import Excel
                </a>
                <a href="{{ route('admin.karyawan.tambah') }}" class="flex-1 sm:flex-initial bg-[#137333] hover:bg-green-800 text-white px-4 py-2 rounded-[6px] text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5 uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Manual
                </a>
                
                {{-- Form Hapus Semua --}}
                <form action="{{ route('admin.karyawan.delete_all') }}" method="POST" class="m-0" onsubmit="return confirm('⚠️ PERINGATAN KRITIKAL ⚠️\n\nApakah Anda yakin ingin menghapus SEMUA data karyawan?\n{{ Auth::user()->role === 'superadmin' ? 'Data yang dihapus akan menyesuaikan dengan filter Plant yang sedang aktif.' : 'Semua data karyawan di plant Anda akan terhapus.' }}\n\nTindakan ini tidak dapat dibatalkan!');">
                    @csrf
                    @method('DELETE')
                    @if(Auth::user()->role === 'superadmin')
                        <input type="hidden" name="plant_filter" value="{{ request('plant_filter', 'all') }}">
                    @endif
                    <button type="submit" class="flex-1 sm:flex-initial bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-[6px] text-xs font-bold transition-all border border-red-100 shadow-sm flex items-center justify-center gap-1.5 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-[6px] shadow-sm flex justify-between items-center transition-all duration-300 relative z-50">
            <span class="font-bold text-xs">{{ session('success') }}</span>
            <button @click="show = false" class="text-current opacity-55 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    {{-- Search & Filter Panel --}}
    <div class="bg-white rounded-[6px] shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.karyawan.index') }}" class="flex flex-col md:flex-row gap-3">
            {{-- Search Input --}}
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK, nama, atau departemen..." 
                    class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white font-semibold">
            </div>

            {{-- Gender Filter --}}
            <div class="w-full md:w-44">
                <select name="jeniskelamin" class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none bg-white font-semibold cursor-pointer">
                    <option value="">-- Semua Gender --</option>
                    @foreach($genderOptions as $opt)
                        <option value="{{ $opt }}" {{ request('jeniskelamin') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="w-full md:w-48">
                <select name="status" class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none bg-white font-semibold cursor-pointer">
                    <option value="">-- Semua Status --</option>
                    @foreach($statusOptions as $opt)
                        <option value="{{ $opt }}" {{ request('status') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Submit & Reset buttons --}}
            <div class="flex gap-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-[6px] text-xs font-bold transition-colors shadow-sm cursor-pointer">
                    Filter
                </button>
                @if(request('search') || request('jeniskelamin') || request('status'))
                    <a href="{{ route('admin.karyawan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-[6px] text-xs font-bold transition-colors flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Employees Master Table --}}
    <div class="bg-white rounded-[6px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-[9px] uppercase font-bold tracking-wider">
                        <th class="px-5 py-3 border-b border-gray-200">Nama Karyawan</th>
                        <th class="px-5 py-3 border-b border-gray-200">NIK</th>
                        <th class="px-5 py-3 border-b border-gray-200">JK</th>
                        <th class="px-5 py-3 border-b border-gray-200">Status</th>
                        <th class="px-5 py-3 border-b border-gray-200">Departemen</th>
                        <th class="px-5 py-3 border-b border-gray-200 text-center whitespace-nowrap">Status Tukar</th>
                        <th class="px-5 py-3 border-b border-gray-200 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($karyawans as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-5 py-3 font-bold text-gray-900">{{ $item->nama }}</td>
                            <td class="px-5 py-3 text-xs font-bold text-gray-500">{{ $item->nik }}</td>
                            <td class="px-5 py-3 text-xs font-bold text-gray-400">{{ $item->jeniskelamin ?? '-' }}</td>
                            <td class="px-5 py-3 text-xs font-bold text-gray-400">{{ $item->status ?? '-' }}</td>
                            <td class="px-5 py-3 text-xs font-bold text-gray-500">{{ $item->departemen }}</td>
                            <td class="px-5 py-3 text-center whitespace-nowrap">
                                @if($item->status_tukar == 'sudah')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                        Sudah Ditukar
                                    </span>
                                @elseif($item->status_tukar == 'menunggu')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-amber-50 text-amber-700 border border-amber-200/50">
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($item->status_tukar == 'ditolak')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-red-50 text-red-700 border border-red-200/50">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black bg-slate-50 text-slate-500 border border-slate-200/50">
                                        Belum Ditukar
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 align-middle text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2 shrink-0">
                                {{-- Edit Trigger Button --}}
                                <button type="button" 
                                    @click="activeKaryawan = { 
                                        id: '{{ $item->id }}', 
                                        nik: '{{ $item->nik }}', 
                                        nama: '{{ addslashes($item->nama) }}', 
                                        departemen: '{{ addslashes($item->departemen) }}', 
                                        jeniskelamin: '{{ $item->jeniskelamin ?? '' }}', 
                                        status: '{{ addslashes($item->status ?? '') }}' 
                                    }; showEditModal = true"
                                    class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-2 py-1 rounded-[6px] text-[10px] font-extrabold transition-all border border-blue-100 shadow-sm cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </button>
                                
                                {{-- Delete Form --}}
                                <form method="POST" action="{{ route('admin.karyawan.delete', $item->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data karyawan {{ addslashes($item->nama) }}?')" 
                                        class="bg-red-50 hover:bg-red-100 text-red-700 px-2 py-1 rounded-[6px] text-[10px] font-extrabold transition-all border border-red-100 shadow-sm cursor-pointer">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Delete
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-gray-400 font-bold">Tidak ada data karyawan yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        
        {{-- Pagination & Rows Per Page --}}
        <div class="bg-white px-5 py-4 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 text-xs font-semibold text-gray-500 order-2 md:order-1">
                <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 m-0">
                    @foreach(request()->except(['per_page', 'karyawans_page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <span>Tampilkan</span>
                    <select name="per_page" onchange="this.form.submit()" class="px-2 py-1 border border-gray-200 rounded-[4px] focus:outline-none focus:ring-1 focus:ring-emerald-500 bg-gray-50 text-xs font-bold text-gray-700 cursor-pointer">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                    <span>data</span>
                </form>
                <div class="border-l border-gray-300 h-4 mx-1"></div>
                <div>
                    Menampilkan <span class="font-extrabold text-gray-900">{{ $karyawans->firstItem() ?? 0 }}</span>
                    - <span class="font-extrabold text-gray-900">{{ $karyawans->lastItem() ?? 0 }}</span>
                    dari <span class="font-extrabold text-gray-900">{{ $karyawans->total() }}</span>
                </div>
            </div>
            <div class="order-1 md:order-2">
                {{ $karyawans->appends(request()->query())->links('vendor.pagination.custom-link') }}
            </div>
        </div>

    </div>

    {{-- Dynamic AlpineJS Modal for Edit Karyawan --}}
    </div>

    <div x-show="showEditModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div class="bg-white rounded-[6px] shadow-xl border border-gray-100 max-w-lg w-full overflow-hidden transform transition-all"
             @click.away="showEditModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            {{-- Modal Header --}}
            <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900">Edit Profil Karyawan</h3>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Perbarui informasi data karyawan</p>
                </div>
                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form method="POST" :action="'/admin/karyawan/' + activeKaryawan.id" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- NIK --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">NIK</label>
                        <input type="text" name="nik" x-model="activeKaryawan.nik" required
                            class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white font-semibold">
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama" x-model="activeKaryawan.nama" required
                            class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white font-semibold">
                    </div>

                    {{-- Departemen --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Departemen</label>
                        <input type="text" name="departemen" x-model="activeKaryawan.departemen" required
                            class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white font-semibold">
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Jenis Kelamin</label>
                        <select name="jeniskelamin" x-model="activeKaryawan.jeniskelamin"
                            class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none bg-white font-semibold cursor-pointer">
                            <option value="">-- Pilih Gender --</option>
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                    </div>

                    {{-- Status Karyawan --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Karyawan</label>
                        <input type="text" name="status" x-model="activeKaryawan.status"
                            class="w-full rounded-[6px] border border-gray-200 px-3 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white">
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-gray-100 mt-6">
                    <button type="button" @click="showEditModal = false" 
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-[6px] text-xs font-bold transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                        class="bg-[#137333] hover:bg-green-800 text-white px-5 py-2 rounded-[6px] text-xs font-bold transition-colors shadow-sm cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
