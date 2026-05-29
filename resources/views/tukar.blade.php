@php
    // Determine theme colors based on plantId
    // Plant 1 = Red, Plant 3 = Green (default), Plant 4 = Blue
    $theme = [
        'primary' => 'bg-[#1b5e20]',
        'primary_hover' => 'hover:bg-green-800',
        'primary_text' => 'text-green-700',
        'primary_dark_text' => 'text-green-900',
        'bg_light' => 'bg-[#ebf5ec]',
        'bg_light_hover' => 'hover:bg-[#e2f0e4]',
        'border_color' => 'border-green-200',
        'accent' => 'green',
        'header_bg' => 'bg-[#14532d]', // green-900
        'footer_bg' => 'bg-[#14532d]',
        'btn_hover_text' => 'hover:text-[#14532d]',
        'focus_ring' => 'focus:ring-2 focus:ring-green-700 focus:border-green-700',
        'btn_outline' => 'border-green-700 text-green-700 hover:bg-green-50',
    ];

    if ($plantId == 1) {
        $theme = [
            'primary' => 'bg-[#b91c1c]', // red-700
            'primary_hover' => 'hover:bg-red-800',
            'primary_text' => 'text-red-700',
            'primary_dark_text' => 'text-red-900',
            'bg_light' => 'bg-[#fdf2f2]',
            'bg_light_hover' => 'hover:bg-[#fde8e8]',
            'border_color' => 'border-red-200',
            'accent' => 'red',
            'header_bg' => 'bg-[#7f1d1d]', // red-900
            'footer_bg' => 'bg-[#7f1d1d]',
            'btn_hover_text' => 'hover:text-[#7f1d1d]',
            'focus_ring' => 'focus:ring-2 focus:ring-red-700 focus:border-red-700',
            'btn_outline' => 'border-red-700 text-red-700 hover:bg-red-50',
        ];
    } elseif ($plantId == 4) {
        $theme = [
            'primary' => 'bg-[#1d4ed8]', // blue-700
            'primary_hover' => 'hover:bg-blue-800',
            'primary_text' => 'text-blue-700',
            'primary_dark_text' => 'text-blue-900',
            'bg_light' => 'bg-[#eef2ff]',
            'bg_light_hover' => 'hover:bg-[#e0e7ff]',
            'border_color' => 'border-blue-200',
            'accent' => 'blue',
            'header_bg' => 'bg-[#1e3a8a]', // blue-900
            'footer_bg' => 'bg-[#1e3a8a]',
            'btn_hover_text' => 'hover:text-[#1e3a8a]',
            'focus_ring' => 'focus:ring-2 focus:ring-blue-700 focus:border-blue-700',
            'btn_outline' => 'border-blue-700 text-blue-700 hover:bg-blue-50',
        ];
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="{{ asset('kambing.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Kupon Qurban - Plant {{ $plantId }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50 font-sans text-gray-900 min-h-screen flex flex-col">

    <!-- Top Nav -->
    <header class="{{ $theme['header_bg'] }} sticky top-0 z-50 shadow-md">
        <div
            class="max-w-[1400px] mx-auto px-4 sm:px-6 py-3 sm:py-0 min-h-[4rem] flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo MW" class="h-6 sm:h-8 brightness-0 invert">
                <span
                    class="font-bold text-white text-sm sm:text-base tracking-wider uppercase whitespace-nowrap">KUPON</span>
            </div>
            <div class="flex items-center justify-center flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
                {{-- Plant Switcher --}}
                <div class="flex items-center gap-1.5">
                    <!-- Desktop -->
                    <div class="hidden sm:flex items-center gap-1.5">
                        <a href="{{ route('karyawan.tukar', '1') }}"
                            class="text-xs font-bold px-3 py-1.5 rounded transition-all uppercase tracking-wider border-2
                                {{ $plantId == 1
                                    ? 'border-white bg-white ' . $theme['primary_text'] . ' shadow-sm'
                                    : 'border-white/50 text-white/80 hover:border-white hover:bg-white/10' }}">
                            Plant 1
                        </a>
                        <a href="{{ route('karyawan.tukar', '3') }}"
                            class="text-xs font-bold px-3 py-1.5 rounded transition-all uppercase tracking-wider border-2
                                {{ $plantId == 3
                                    ? 'border-white bg-white ' . $theme['primary_text'] . ' shadow-sm'
                                    : 'border-white/50 text-white/80 hover:border-white hover:bg-white/10' }}">
                            Plant 3
                        </a>
                        <a href="{{ route('karyawan.tukar', '4') }}"
                            class="text-xs font-bold px-3 py-1.5 rounded transition-all uppercase tracking-wider border-2
                                {{ $plantId == 4
                                    ? 'border-white bg-white ' . $theme['primary_text'] . ' shadow-sm'
                                    : 'border-white/50 text-white/80 hover:border-white hover:bg-white/10' }}">
                            Plant 4
                        </a>
                    </div>
                    <!-- Mobile Dropdown -->
                    <div class="sm:hidden relative">
                        <select onchange="window.location.href=this.value" 
                            class="bg-transparent border-2 border-white text-white text-xs font-bold px-3 py-1.5 rounded uppercase tracking-wider focus:outline-none focus:ring-0 cursor-pointer">
                            <option value="{{ route('karyawan.tukar', '1') }}" class="text-gray-900" {{ $plantId == 1 ? 'selected' : '' }}>Plant 1</option>
                            <option value="{{ route('karyawan.tukar', '3') }}" class="text-gray-900" {{ $plantId == 3 ? 'selected' : '' }}>Plant 3</option>
                            <option value="{{ route('karyawan.tukar', '4') }}" class="text-gray-900" {{ $plantId == 4 ? 'selected' : '' }}>Plant 4</option>
                        </select>
                    </div>
                </div>

                {{-- Divider --}}
                <span class="text-white/30 hidden sm:block">|</span>

                {{-- Login Button --}}
                <a href="{{ route('login') }}"
                    class="text-sm border-2 border-white text-white {{ $theme['btn_hover_text'] }} hover:bg-white px-4 py-1.5 rounded font-bold transition-all uppercase tracking-wider">
                    Login
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-[1400px] w-full mx-auto px-4 sm:px-6 py-8 flex-1" x-data="tukarKupon()">

        <!-- Hero Banner -->
        <div
            class="{{ $theme['bg_light'] }} rounded-xl p-4 sm:py-5 sm:px-8 mb-6 flex items-center justify-between relative overflow-hidden shadow-sm">
            <div class="z-10 w-[65%] sm:w-1/2">
                <span
                    class="inline-block bg-white {{ $theme['primary_text'] }} text-[10px] sm:text-xs font-bold px-3 py-1 rounded mb-3 shadow-sm">Qurban
                    1447 H / 2026</span>
                <h1
                    class="text-2xl sm:text-3xl md:text-4xl font-bold {{ $theme['primary_dark_text'] }} mb-2 leading-tight">
                    Tukar Kupon Qurban</h1>
                <p class="{{ $theme['primary_text'] }} opacity-80 text-xs sm:text-sm leading-relaxed pr-2 sm:max-w-md">
                    Cari nama atau NIK Anda — jika belum terdaftar, isi form pendaftaran di samping.</p>
            </div>
            <div
                class="absolute right-[-10px] sm:right-0 bottom-0 h-full w-[45%] sm:w-[35%] flex justify-end items-end">
                <img src="{{ asset('assets/images/kurban.png') }}" alt="Ilustrasi Kurban"
                    class="h-[120%] object-contain object-bottom origin-bottom-right">
            </div>
        </div>

        <!-- Main 2-col: Search + Result -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- LEFT: Live Search -->
                <div>
                    <div
                        class="bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] border border-gray-100 p-6 sm:p-8 h-full flex flex-col">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="w-12 h-12 {{ $theme['bg_light'] }} {{ $theme['primary_text'] }} rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 leading-tight">Cari Data Karyawan</h2>
                                <p class="text-xs text-gray-500 mt-1">Ketik nama atau NIK — rekomendasi muncul otomatis.
                                </p>
                            </div>
                        </div>

                        <!-- Search Input + Dropdown -->
                        <div class="relative flex-1 flex flex-col gap-4">
                            <div class="relative">
                                <input type="text" x-model="searchQuery" @input.debounce.300ms="liveSearch()"
                                    @keydown.escape="closeDropdown()" @focus="searchQuery.length >= 2 && liveSearch()"
                                    class="w-full px-5 py-4 pr-12 bg-white border border-gray-200 rounded-lg {{ $theme['focus_ring'] }} outline-none text-base placeholder-gray-400 shadow-sm transition-all"
                                    placeholder="Ketik nama atau NIK...">



                                <!-- Dropdown -->
                                <div x-show="showDropdown" @click.away="closeDropdown()"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute top-full left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-30 overflow-hidden"
                                    style="display:none">

                                    <!-- Loading -->
                                    <div x-show="loadingDropdown"
                                        class="px-4 py-3 text-xs text-gray-400 flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z">
                                            </path>
                                        </svg>
                                        Mencari...
                                    </div>

                                    <!-- DB Results -->
                                    <template x-for="item in dropdown" :key="item.id">
                                        <button @click="selectExisting(item)"
                                            class="w-full text-left px-4 py-3 hover:{{ $theme['bg_light'] }} transition-colors border-b border-gray-50 last:border-0 flex items-center gap-3 group">
                                            <div
                                                class="w-8 h-8 {{ $theme['bg_light'] }} {{ $theme['primary_text'] }} rounded-full flex items-center justify-center shrink-0 text-xs font-black">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold text-gray-900 text-sm truncate"
                                                    x-text="item.nama"></p>
                                                <p class="text-xs text-gray-400 truncate"
                                                    x-text="'NIK: ' + item.nik + ' · ' + item.departemen"></p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-300 group-hover:{{ $theme['primary_text'] }} transition-colors shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </template>

                                    <!-- Separator if there are db results -->
                                    <div x-show="dropdown.length > 0 && !loadingDropdown"
                                        class="border-t border-dashed border-gray-200 mx-3"></div>

                                    <!-- Walk-in option (always shown when typing) -->
                                    <button x-show="!loadingDropdown" @click="selectWalkin()"
                                        class="w-full text-left px-4 py-3 hover:bg-red-50 transition-colors flex items-start gap-3 group border-t border-red-100 bg-red-50/30">
                                        <div
                                            class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0 border border-red-200 mt-0.5 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-extrabold text-red-700 text-sm">
                                                Input Data Manual
                                            </p>
                                            <p class="text-[10px] font-black text-red-600 mt-0.5 leading-tight uppercase tracking-wider">
                                                PERINGATAN: DILARANG MENGISI KECUALI OLEH TIM HRD & IT
                                            </p>
                                        </div>
                                        <svg class="w-4 h-4 text-red-300 group-hover:text-red-500 transition-colors shrink-0 mt-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Selection summary pill (setelah pilih) -->
                            <div x-show="selectedMode !== null"
                                class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5"
                                style="display:none" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                                <div class="flex items-center gap-2">
                                    <div :class="selectedMode === 'walkin' ? 'bg-amber-100 text-amber-700' :
                                        '{{ $theme['bg_light'] }} {{ $theme['primary_text'] }}'"
                                        class="w-6 h-6 rounded-full flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-gray-700"
                                        x-text="selectedMode === 'walkin' ? 'Pendaftaran baru: ' + searchQuery : 'Dipilih: ' + (selected?.nama ?? '')"></span>
                                </div>
                                <button @click="resetForm()"
                                    class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Result Panel -->
                <div>

                    <!-- Placeholder: belum ada pilihan -->
                    <div x-show="selectedMode === null"
                        class="bg-white rounded-xl border border-gray-100 p-6 sm:p-8 text-center shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] h-full flex flex-col justify-center items-center">
                        <div
                            class="w-16 h-16 {{ $theme['bg_light'] }} {{ $theme['primary_text'] }} rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Hasil Pencarian</h3>
                        <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">Ketik nama atau NIK di kolom
                            kiri, pilih dari rekomendasi yang muncul.</p>
                    </div>

                    <!-- Card: Karyawan ditemukan di DB -->
                    <div x-show="selectedMode === 'existing'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] border border-gray-100 p-6 sm:p-8 h-full flex flex-col justify-between"
                        style="display:none">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="w-12 h-12 {{ $theme['bg_light'] }} {{ $theme['primary_text'] }} rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 leading-tight">Data Ditemukan</h2>
                                <p class="text-xs text-gray-500 mt-1">Verifikasi data Anda sebelum menukar kupon.</p>
                            </div>
                        </div>
                        <div class="space-y-4 flex-1">
                            <div
                                class="{{ $theme['bg_light'] }} p-5 rounded-lg border {{ $theme['border_color'] }}/50">
                                <p class="text-xs text-gray-500 font-medium mb-1">Nama Karyawan</p>
                                <h4 class="text-xl font-black text-gray-900 leading-tight" x-text="selected?.nama">
                                </h4>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-500 font-medium mb-1">NIK</p>
                                    <p class="font-bold text-gray-900 text-base" x-text="selected?.nik"></p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-500 font-medium mb-1">Departemen</p>
                                    <p class="font-bold text-gray-900 text-base" x-text="selected?.departemen"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-500 font-medium mb-1">Jenis Kelamin</p>
                                    <p class="font-bold text-gray-900 text-base"
                                        x-text="selected?.jeniskelamin || '-'"></p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-500 font-medium mb-1">Status Karyawan</p>
                                    <p class="font-bold text-gray-900 text-base" x-text="selected?.status || '-'"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Tukar (Jika belum/ditolak) -->
                        <template x-if="!selected || ['belum', 'ditolak'].includes(selected?.status_tukar)">
                            <button @click="prosesTukar()" :disabled="processing"
                                class="w-full {{ $theme['primary'] }} {{ $theme['primary_hover'] }} text-white font-bold py-4 rounded-lg transition-colors flex justify-center items-center gap-2 disabled:opacity-70 shadow-sm"
                                style="margin-top: 32px;">
                                <span x-show="!processing" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Tukar Kupon
                                </span>
                                <span x-show="processing">Memproses...</span>
                            </button>
                        </template>

                        <!-- Tracking UI (Jika menunggu/sudah) -->
                        <template x-if="selected && ['menunggu', 'sudah'].includes(selected?.status_tukar)">
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <h4 class="text-sm font-bold text-gray-900 mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Status Pelacakan Penukaran
                                </h4>

                                <div class="relative pl-4 space-y-6">
                                    <!-- Garis Vertikal -->
                                    <div class="absolute top-2 bottom-2" style="left: 23px; width: 3px; border-left: 3px dashed #9ca3af; z-index: 0;"></div>

                                    <!-- Step 1: Pendaftaran -->
                                    <div class="relative flex gap-4">
                                        <div class="w-4 h-4 rounded-full bg-emerald-500 z-10 shrink-0 mt-1 ring-4 ring-white">
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-gray-900">Pendaftaran Penukaran</p>
                                            <p class="text-xs text-gray-500 mt-0.5">Kupon berhasil didaftarkan.</p>
                                            <p class="text-[10px] text-gray-400 mt-1 font-mono font-medium"
                                                x-text="formatDate(selected?.waktu_tukar)"></p>
                                        </div>
                                    </div>

                                    <!-- Step 2: Menunggu Diproses -->
                                    <div class="relative flex gap-4">
                                        <div class="w-4 h-4 rounded-full z-10 shrink-0 mt-1 ring-4 ring-white"
                                            :style="selected?.status_tukar === 'menunggu' ? 'background-color: #fbbf24; opacity: 0.8;' : 'background-color: #10b981;'">
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-gray-900">Proses Konfirmasi Admin</p>
                                            <p class="text-xs mt-0.5"
                                                :style="selected?.status_tukar === 'menunggu' ? 'color: #d97706; font-weight: 600;' : 'color: #6b7280;'"
                                                x-text="selected?.status_tukar === 'menunggu' ? 'Menunggu admin memproses permintaan Anda...' : 'Admin telah mengkonfirmasi.'">
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Step 3: Selesai -->
                                    <div class="relative flex gap-4">
                                        <div class="w-4 h-4 rounded-full z-10 shrink-0 mt-1 ring-4 ring-white"
                                            :class="selected?.status_tukar === 'sudah' ? 'bg-emerald-500' : 'bg-gray-200'">
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-gray-900"
                                                :class="selected?.status_tukar === 'sudah' ? '' : 'text-gray-400'">
                                                Penukaran Selesai</p>
                                            <p class="text-xs mt-0.5"
                                                :class="selected?.status_tukar === 'sudah' ? 'text-gray-500' :
                                                    'text-gray-400'">
                                                Kupon atau Pack berhasil diserahkan.</p>
                                            <p class="text-[10px] text-gray-400 mt-1 font-mono font-medium"
                                                x-show="selected?.status_tukar === 'sudah'"
                                                x-text="formatDate(selected?.waktu_konfirmasi)"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Form: Walk-in / Tidak ada di DB -->
                    <div x-show="selectedMode === 'walkin'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] border border-amber-200 p-6 sm:p-8 h-full flex flex-col"
                        style="display:none">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center shrink-0 border border-amber-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 leading-tight">Pendaftaran Baru</h2>
                                <p class="text-xs text-amber-600 mt-1 font-semibold">Nama tidak ditemukan di database —
                                    isi data di bawah.</p>
                            </div>
                        </div>

                        <div class="space-y-4 flex-1">
                            <!-- Nama -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" x-model="walkin.nama" placeholder="Nama lengkap..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none text-sm font-semibold bg-white shadow-sm">
                            </div>
                            <!-- Status -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Pengambil <span
                                        class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="text" x-model="walkin.status"
                                    placeholder="Misal: Warga sekitar, Yayasan..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none text-sm font-semibold bg-white shadow-sm">
                            </div>
                            <!-- Qty Ambil -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Jumlah Pack Diambil <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center gap-3">
                                    <button @click="walkin.qty_ambil = Math.max(1, walkin.qty_ambil - 1)"
                                        class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-black text-xl flex items-center justify-center transition-colors cursor-pointer">−</button>
                                    <input type="number" x-model.number="walkin.qty_ambil" min="1"
                                        max="20"
                                        class="w-20 text-center border border-gray-200 rounded-lg px-3 py-2.5 text-base font-black focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">
                                    <button @click="walkin.qty_ambil = Math.min(20, walkin.qty_ambil + 1)"
                                        class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-black text-xl flex items-center justify-center transition-colors cursor-pointer">+</button>
                                    <span class="text-xs text-gray-400 font-semibold">pack</span>
                                </div>
                            </div>
                        </div>

                        <button @click="prosesTukarBaru()" :disabled="processing || !walkin.nama.trim()"
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-lg transition-colors flex justify-center items-center gap-2 disabled:opacity-50 shadow-sm cursor-pointer"
                            style="margin-top: 32px;">
                            <span x-show="!processing" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                Daftarkan & Tukar Kupon
                            </span>
                            <span x-show="processing">Memproses...</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="{{ $theme['footer_bg'] }} text-white mt-auto border-t border-white/10 flex items-center" style="height: 64px;">
        <div class="max-w-[1400px] w-full mx-auto px-4 sm:px-6 flex justify-end">
            <!-- Copyright -->
            <div class="flex flex-col items-end gap-1.5 text-[11px] sm:text-xs text-white/80 text-right">
                <span class="bg-white/10 px-2 py-0.5 rounded-full font-semibold inline-block">Qurban 1447 H / 2026</span>
                <p>© {{ date('Y') }} PT Mada Wikri Tunggal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function tukarKupon() {
            return {
                searchQuery: '',
                loadingDropdown: false,
                showDropdown: false,
                dropdown: [],
                selectedMode: null, // null | 'existing' | 'walkin'
                selected: null, // karyawan object from DB
                walkin: {
                    nama: '',
                    status: '',
                    qty_ambil: 1
                },
                processing: false,
                successMode: false,
                showToast: false,
                plantId: '{{ $plantId }}',

                formatDate(dateStr) {
                    if (!dateStr) return '-';
                    const d = new Date(dateStr);
                    if (isNaN(d.getTime())) return '-';
                    const pad = (n) => n.toString().padStart(2, '0');
                    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
                },

                async liveSearch() {
                    if (this.searchQuery.trim().length < 2) {
                        this.dropdown = [];
                        this.showDropdown = false;
                        return;
                    }
                    this.loadingDropdown = true;
                    this.showDropdown = true;
                    try {
                        const res = await fetch(
                            `/api/search/${this.plantId}?q=${encodeURIComponent(this.searchQuery)}`);
                        this.dropdown = await res.json();
                    } catch (e) {
                        this.dropdown = [];
                    } finally {
                        this.loadingDropdown = false;
                    }
                },

                closeDropdown() {
                    this.showDropdown = false;
                },

                selectExisting(item) {
                    this.selected = item;
                    this.selectedMode = 'existing';
                    this.searchQuery = item.nama;
                    this.showDropdown = false;
                },

                selectWalkin() {
                    this.selectedMode = 'walkin';
                    this.walkin.nama = this.searchQuery;
                    this.walkin.status = '';
                    this.walkin.qty_ambil = 1;
                    this.showDropdown = false;
                },

                async prosesTukar() {
                    if (!this.selected) return;
                    this.processing = true;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        const res = await fetch('/tukar/proses', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                id: this.selected.id
                            })
                        });
                        const data = await res.json();
                        if (res.ok && data.success) {
                            this.showSuccessToast();
                        } else {
                            alert(data.error || 'Terjadi kesalahan sistem.');
                        }
                    } catch (e) {
                        alert('Koneksi bermasalah. Coba lagi.');
                    } finally {
                        this.processing = false;
                    }
                },

                async prosesTukarBaru() {
                    if (!this.walkin.nama.trim()) return;
                    this.processing = true;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        const res = await fetch('/tukar/proses-baru', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                nama: this.walkin.nama,
                                status: this.walkin.status,
                                qty_ambil: this.walkin.qty_ambil,
                                plant: this.plantId,
                            })
                        });
                        const data = await res.json();
                        if (res.ok && data.success) {
                            this.showSuccessToast();
                        } else {
                            const errors = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message ||
                                'Terjadi kesalahan.');
                            alert(errors);
                        }
                    } catch (e) {
                        alert('Koneksi bermasalah. Coba lagi.');
                    } finally {
                        this.processing = false;
                    }
                },

                showSuccessToast() {
                    this.showToast = true;
                    document.dispatchEvent(new Event('show-toast'));
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },

                resetForm() {
                    this.searchQuery = '';
                    this.dropdown = [];
                    this.showDropdown = false;
                    this.selectedMode = null;
                    this.selected = null;
                    this.walkin = {
                        nama: '',
                        status: '',
                        qty_ambil: 1
                    };
                    this.successMode = false;
                    this.processing = false;
                }
            }
        }
    </script>

    <!-- Success Modal Popup -->
    <div id="successModal" style="
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,0,0,0.45);
        backdrop-filter: blur(4px);
        align-items: center;
        justify-content: center;
    ">
        <div id="successModalBox" style="
            background: white;
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            text-align: center;
            width: 90%;
            max-width: 340px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.25);
            animation: popIn 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards;
        ">
            <!-- Checkmark circle -->
            <div style="
                width: 5rem; height: 5rem;
                background: linear-gradient(135deg, #16a34a, #22c55e);
                border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                margin: 0 auto 1.25rem;
                box-shadow: 0 8px 24px rgba(34,197,94,0.35);
            ">
                <svg style="width:2.25rem;height:2.25rem;" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p style="font-size:1.6rem; font-weight:800; color:#111827; margin:0 0 0.35rem;">Berhasil!</p>
            <p style="font-size:0.9rem; color:#6b7280; margin:0;">Kupon Qurban berhasil didaftarkan.</p>
        </div>
    </div>

    <script>
        document.addEventListener('show-toast', function() {
            const modal = document.getElementById('successModal');
            modal.style.display = 'flex';
        });
    </script>

    <style>
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.7); }
            to   { opacity: 1; transform: scale(1); }
        }
    </style>
</body>

</html>
