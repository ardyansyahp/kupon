@extends('layouts.admin')

@section('content')
<div class="fade-in space-y-6 max-w-full">

    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Rekapitulasi</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Rekapitulasi</p>
        </div>
        
        {{-- Filters & Options --}}
        <div class="flex items-center gap-3">
            @if(Auth::user()->role === 'superadmin')
            <form method="GET" action="{{ url()->current() }}" class="flex items-center">
                <select name="plant_filter" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-gray-200 rounded-[6px] text-xs focus:outline-none focus:border-emerald-500 font-semibold shadow-sm">
                    <option value="all" {{ (request('plant_filter') ?? 'all') == 'all' ? 'selected' : '' }}>Semua Plant</option>
                    <option value="1" {{ request('plant_filter') == '1' ? 'selected' : '' }}>Plant 1</option>
                    <option value="3" {{ request('plant_filter') == '3' ? 'selected' : '' }}>Plant 3</option>
                    <option value="4" {{ request('plant_filter') == '4' ? 'selected' : '' }}>Plant 4</option>
                </select>
            </form>
            @endif

            {{-- Periode Select Box --}}
            <div class="flex items-center gap-2 bg-white border border-gray-100 shadow-sm rounded-[6px] px-3.5 py-2">
                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Periode</span>
                <span class="text-xs font-extrabold text-gray-800">1447 H / 2026</span>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-[6px] shadow-sm flex justify-between items-center transition-all duration-300">
            <span class="font-bold text-xs">{{ session('success') }}</span>
            <button @click="show = false" class="text-base font-bold leading-none">&times;</button>
        </div>
    @endif

    {{-- Dynamic Math Calculations for Metrics and Charts --}}
    @php
        $total = $totalKaryawan > 0 ? $totalKaryawan : 1;
        $pctSudah = ($sudahDitukar / $total) * 100;
        $pctMenunggu = ($menunggu / $total) * 100;
        $pctBelum = ($belumDitukar / $total) * 100;

        // Circumference of Circle R=50 is 314.16
        $c = 314.16;
        $dashSudah = ($pctSudah / 100) * $c;
        $dashMenunggu = ($pctMenunggu / 100) * $c;
        $dashBelum = ($pctBelum / 100) * $c;

        $offsetSudah = 0;
        $offsetMenunggu = $dashSudah;
        $offsetBelum = $dashSudah + $dashMenunggu;
    @endphp

    {{-- 5 Columns Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        {{-- Card 1: Total Karyawan --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-4 shadow-sm flex flex-col justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-blue-50 text-blue-500 border border-blue-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Total Karyawan</p>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-gray-900 leading-none">{{ $totalKaryawan }}</span>
                        <span class="text-[9px] text-gray-400 font-bold">Orang</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-50 flex items-center gap-1.5 text-[9px] font-bold text-blue-500">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>100% dari total karyawan</span>
            </div>
        </div>

        {{-- Card 2: Sudah Ditukar --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-4 shadow-sm flex flex-col justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-emerald-500 border border-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Sudah Ditukar</p>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-gray-900 leading-none">{{ $sudahDitukar }}</span>
                        <span class="text-[9px] text-gray-400 font-bold">Orang</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-50 flex items-center gap-1.5 text-[9px] font-bold text-emerald-600">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ number_format($pctSudah, 1, ',', '.') }}% dari total karyawan</span>
            </div>
        </div>

        {{-- Card 3: Menunggu Konfirmasi --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-4 shadow-sm flex flex-col justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-amber-50 text-amber-500 border border-amber-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Menunggu Konfirmasi</p>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-gray-900 leading-none">{{ $menunggu }}</span>
                        <span class="text-[9px] text-gray-400 font-bold">Orang</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-50 flex items-center gap-1.5 text-[9px] font-bold text-amber-600">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span>{{ number_format($pctMenunggu, 1, ',', '.') }}% dari total karyawan</span>
            </div>
        </div>

        {{-- Card 4: Belum Ditukar --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-4 shadow-sm flex flex-col justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-red-50 text-red-500 border border-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Belum Ditukar</p>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-gray-900 leading-none">{{ $belumDitukar }}</span>
                        <span class="text-[9px] text-gray-400 font-bold">Orang</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-50 flex items-center gap-1.5 text-[9px] font-bold text-red-500">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>{{ number_format($pctBelum, 1, ',', '.') }}% dari total karyawan</span>
            </div>
        </div>

        {{-- Card 5: Total Kupon --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-4 shadow-sm flex flex-col justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-purple-50 text-purple-500 border border-purple-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Total Kupon</p>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-gray-900 leading-none">{{ $totalKaryawan }}</span>
                        <span class="text-[9px] text-gray-400 font-bold">Kupon</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-50 flex items-center gap-1.5 text-[9px] font-bold text-purple-500">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M7 7h.01M6 20h12a2 2 0 002-2V9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                <span>1 kupon per karyawan</span>
            </div>
        </div>

    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
        {{-- Donut Chart --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-5 shadow-sm flex flex-col justify-between min-h-[300px]">
            <h3 class="font-extrabold text-gray-800 text-sm pb-3 border-b border-gray-100">Persentase Status Tukar Kupon</h3>
            <div class="flex flex-col sm:flex-row items-center justify-around gap-6 py-4 flex-1">
                
                {{-- SVG Circular Donut Chart --}}
                <div class="relative w-40 h-40 flex items-center justify-center shrink-0 select-none">
                    <svg class="w-40 h-40 transform -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="transparent" stroke="#f8fafc" stroke-width="11" />
                        @if($totalKaryawan > 0)
                            <!-- Sudah (Emerald Green) -->
                            <circle cx="60" cy="60" r="50" fill="transparent" stroke="#10b981" stroke-width="11" 
                                    stroke-dasharray="{{ $dashSudah }} {{ $c }}" stroke-dashoffset="0" />
                            <!-- Menunggu (Amber Orange) -->
                            <circle cx="60" cy="60" r="50" fill="transparent" stroke="#f59e0b" stroke-width="11" 
                                    stroke-dasharray="{{ $dashMenunggu }} {{ $c }}" stroke-dashoffset="-{{ $offsetMenunggu }}" />
                            <!-- Belum (Red) -->
                            <circle cx="60" cy="60" r="50" fill="transparent" stroke="#ef4444" stroke-width="11" 
                                    stroke-dasharray="{{ $dashBelum }} {{ $c }}" stroke-dashoffset="-{{ $offsetBelum }}" />
                        @endif
                    </svg>
                    
                    {{-- Total Text Overlay --}}
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <span class="text-2xl font-black text-gray-900 leading-none">{{ $totalKaryawan }}</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1">Total</span>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="space-y-3.5 w-full sm:w-1/2">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 bg-emerald-500 rounded-full shrink-0"></span>
                            <span class="font-bold text-gray-600">Sudah Ditukar</span>
                        </div>
                        <span class="font-extrabold text-gray-900">{{ $sudahDitukar }} ({{ number_format($pctSudah, 1, ',', '.') }}%)</span>
                    </div>
                    
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 bg-amber-500 rounded-full shrink-0"></span>
                            <span class="font-bold text-gray-600">Menunggu Konfirmasi</span>
                        </div>
                        <span class="font-extrabold text-gray-900">{{ $menunggu }} ({{ number_format($pctMenunggu, 1, ',', '.') }}%)</span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 bg-red-500 rounded-full shrink-0"></span>
                            <span class="font-bold text-gray-600">Belum Ditukar</span>
                        </div>
                        <span class="font-extrabold text-gray-900">{{ $belumDitukar }} ({{ number_format($pctBelum, 1, ',', '.') }}%)</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Line Chart --}}
        @php
            $plant = $activePlant;
            // 1. Find distribution date (most recent waktu_tukar or today)
            $latestPenukaran = \App\Models\Karyawan::where('plant', $plant)
                ->whereNotNull('waktu_tukar')
                ->latest('waktu_tukar')
                ->first();
            
            $distDate = $latestPenukaran 
                ? \Carbon\Carbon::parse($latestPenukaran->waktu_tukar)->toDateString() 
                : \Carbon\Carbon::today()->toDateString();
                
            $distDateFormatted = \Carbon\Carbon::parse($distDate)->translatedFormat('d F Y');

            // 2. Define target hours
            $hours = ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'];
            
            $chartData = [];
            $maxVal = $totalKaryawan > 0 ? $totalKaryawan : 100;
            
            // We want to calculate cumulative numbers for each hour point
            foreach ($hours as $index => $hour) {
                $dateTimeStr = "$distDate $hour:00";
                
                $sudah = \App\Models\Karyawan::where('plant', $plant)
                    ->where('status_tukar', 'sudah')
                    ->where('waktu_tukar', '<=', $dateTimeStr)
                    ->count();
                    
                $menunggu = \App\Models\Karyawan::where('plant', $plant)
                    ->where('status_tukar', 'menunggu')
                    ->where('waktu_tukar', '<=', $dateTimeStr)
                    ->count();
                    
                $belum = max(0, $totalKaryawan - ($sudah + $menunggu));
                
                $chartData[] = [
                    'hour' => $hour,
                    'sudah' => $sudah,
                    'menunggu' => $menunggu,
                    'belum' => $belum
                ];
            }
            
            // 3. Scale values for Y-axis (height = 150px, Y ranges from 20 to 170 in SVG)
            // Formula: y = 170 - (val / maxVal) * 150
            $pointsSudah = [];
            $pointsMenunggu = [];
            $pointsBelum = [];
            $xCoords = [40, 130, 220, 310, 400, 490];
            
            foreach ($chartData as $index => $data) {
                $x = $xCoords[$index];
                
                $ySudah = 170 - ($data['sudah'] / $maxVal) * 150;
                $yMenunggu = 170 - ($data['menunggu'] / $maxVal) * 150;
                $yBelum = 170 - ($data['belum'] / $maxVal) * 150;
                
                $pointsSudah[] = "$x,$ySudah";
                $pointsMenunggu[] = "$x,$yMenunggu";
                $pointsBelum[] = "$x,$yBelum";
            }
            
            $pathSudah = "M " . implode(" L ", $pointsSudah);
            $pathMenunggu = "M " . implode(" L ", $pointsMenunggu);
            $pathBelum = "M " . implode(" L ", $pointsBelum);
            
            // Y-axis grid labels
            $gridLabels = [];
            for ($i = 0; $i <= 5; $i++) {
                $gridLabels[] = round(($maxVal / 5) * $i);
            }
        @endphp
        <div class="bg-white rounded-[6px] border border-gray-100 p-5 shadow-sm flex flex-col justify-between min-h-[300px]">
            <h3 class="font-extrabold text-gray-800 text-sm pb-3 border-b border-gray-100 font-sans tracking-tight">Trend Penukaran Hari Ini ({{ $distDateFormatted }})</h3>
            <div class="flex-1 flex flex-col justify-between gap-3 pt-3 select-none">
                
                {{-- Perfect Custom SVG Line Chart --}}
                <div class="relative w-full flex-1 flex items-center justify-center">
                    <svg viewBox="0 0 500 200" class="w-full h-full min-h-[160px]">
                        <!-- Y-Axis Title -->
                        <text x="25" y="15" fill="#94a3b8" font-size="8" font-weight="800" text-anchor="middle">Jumlah</text>
                        
                        <!-- Grid Lines & Y-Axis Labels -->
                        @foreach($gridLabels as $index => $label)
                            @php $gridY = 170 - ($index * 30); @endphp
                            <line x1="35" y1="{{ $gridY }}" x2="490" y2="{{ $gridY }}" stroke="{{ $index === 0 ? '#cbd5e1' : '#f1f5f9' }}" stroke-width="{{ $index === 0 ? '1.2' : '1' }}" />
                            <text x="30" y="{{ $gridY + 3 }}" fill="#94a3b8" font-size="8" font-weight="700" text-anchor="end">{{ $label }}</text>
                        @endforeach

                        <!-- X-Axis Labels (Hourly intervals) -->
                        @foreach($hours as $index => $hour)
                            @php $px = $xCoords[$index]; @endphp
                            <text x="{{ $px }}" y="185" fill="#94a3b8" font-size="8" font-weight="700" text-anchor="middle">{{ $hour }} WIB</text>
                        @endforeach

                        <!-- Green Curve (Sudah Ditukar) -->
                        <path d="{{ $pathSudah }}" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" />
                        @foreach($pointsSudah as $index => $point)
                            @php [$px, $py] = explode(',', $point); @endphp
                            <circle cx="{{ $px }}" cy="{{ $py }}" r="3.5" fill="#10b981" stroke="#ffffff" stroke-width="1" />
                        @endforeach

                        <!-- Yellow Curve (Menunggu Konfirmasi) -->
                        <path d="{{ $pathMenunggu }}" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" />
                        @foreach($pointsMenunggu as $index => $point)
                            @php [$px, $py] = explode(',', $point); @endphp
                            <circle cx="{{ $px }}" cy="{{ $py }}" r="3.5" fill="#f59e0b" stroke="#ffffff" stroke-width="1" />
                        @endforeach

                        <!-- Red Curve (Belum Ditukar) -->
                        <path d="{{ $pathBelum }}" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" />
                        @foreach($pointsBelum as $index => $point)
                            @php [$px, $py] = explode(',', $point); @endphp
                            <circle cx="{{ $px }}" cy="{{ $py }}" r="3.5" fill="#ef4444" stroke="#ffffff" stroke-width="1" />
                        @endforeach
                    </svg>
                </div>

                {{-- Chart Legend --}}
                <div class="flex items-center justify-center gap-5 text-[10px] font-bold text-gray-500 border-t border-gray-50 pt-2.5">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                        <span>Sudah Ditukar</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-amber-500 rounded-full"></span>
                        <span>Menunggu Konfirmasi</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                        <span>Belum Ditukar</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Bottom Row (Table + Timeline + Info Sidebar) --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        
        {{-- Column 1 & 2: Rekap Departemen --}}
        <div class="bg-white rounded-[6px] border border-gray-100 p-5 shadow-sm xl:col-span-2">
            <h3 class="font-extrabold text-gray-800 text-sm pb-3 border-b border-gray-100">Rekap per Departemen</h3>
            
            @php
                $rekapDept = \App\Models\Karyawan::when($activePlant !== 'all', fn($q) => $q->where('plant', $activePlant))
                    ->select('departemen',
                        \DB::raw('count(*) as total'),
                        \DB::raw('sum(case when status_tukar = "sudah" then 1 else 0 end) as sudah'),
                        \DB::raw('sum(case when status_tukar = "menunggu" then 1 else 0 end) as menunggu'),
                        \DB::raw('sum(case when status_tukar in ("belum", "ditolak") then 1 else 0 end) as belum')
                    )->groupBy('departemen')->get();
            @endphp
            
            {{-- Wrapper scroll: max-h cukup untuk ~10 baris (tiap baris ±42px) + header --}}
            <div class="overflow-x-auto overflow-y-auto mt-2 [&::-webkit-scrollbar]:hidden" style="max-height: 462px; scrollbar-width: none; -ms-overflow-style: none;">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="sticky top-0 bg-white z-10">
                        <tr class="text-gray-400 font-bold uppercase text-[9px] tracking-wider border-b border-gray-200">
                            <th class="pb-3 pt-2 pr-3">Departemen</th>
                            <th class="pb-3 pt-2 text-center whitespace-nowrap">Total Karyawan</th>
                            <th class="pb-3 pt-2 text-center whitespace-nowrap">Sudah Ditukar</th>
                            <th class="pb-3 pt-2 text-center whitespace-nowrap">Menunggu</th>
                            <th class="pb-3 pt-2 text-center whitespace-nowrap">Belum Ditukar</th>
                            <th class="pb-3 pt-2 text-right whitespace-nowrap">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        @forelse($rekapDept as $dept)
                            @php
                                $dTotal = $dept->total > 0 ? $dept->total : 1;
                                $dPct = ($dept->sudah / $dTotal) * 100;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors" style="height: 42px;">
                                <td class="py-3 font-bold text-gray-800 pr-3">{{ $dept->departemen }}</td>
                                <td class="py-3 text-center font-bold text-gray-500">{{ $dept->total }}</td>
                                <td class="py-3 text-center font-bold text-gray-500">{{ $dept->sudah }}</td>
                                <td class="py-3 text-center font-bold text-gray-500">{{ $dept->menunggu }}</td>
                                <td class="py-3 text-center font-bold text-gray-500">{{ $dept->belum }}</td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-2.5">
                                        <div class="w-16 bg-gray-100 h-1.5 rounded-full overflow-hidden shrink-0">
                                            <div class="bg-emerald-600 h-full rounded-full" style="width: {{ $dPct }}%"></div>
                                        </div>
                                        <span class="font-extrabold text-gray-900 text-[10px] w-10 text-right">{{ number_format($dPct, 1, ',', '.') }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 font-bold">Tidak ada data departemen. Silakan import karyawan.</td>
                            </tr>
                        @endforelse

                        {{-- Total Bold Row --}}
                        @if($rekapDept->count() > 0)
                            <tr class="sticky bottom-0 z-10 font-bold bg-white" style="height: 42px; box-shadow: 0 -2px 0 0 #e5e7eb, 0 -6px 10px -2px rgba(0,0,0,0.03);">
                                <td class="py-3 text-gray-900 font-extrabold pr-3">Total</td>
                                <td class="py-3 text-center text-gray-900 font-extrabold">{{ $totalKaryawan }}</td>
                                <td class="py-3 text-center text-gray-900 font-extrabold">{{ $sudahDitukar }}</td>
                                <td class="py-3 text-center text-gray-900 font-extrabold">{{ $menunggu }}</td>
                                <td class="py-3 text-center text-gray-900 font-extrabold">{{ $belumDitukar }}</td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-2.5">
                                        <div class="w-16 bg-gray-200 h-1.5 rounded-full overflow-hidden shrink-0">
                                            <div class="bg-emerald-700 h-full rounded-full" style="width: {{ $pctSudah }}%"></div>
                                        </div>
                                        <span class="font-black text-gray-900 text-[10px] w-10 text-right">{{ number_format($pctSudah, 1, ',', '.') }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Column 3: Timeline --}}
        <div class="flex flex-col">
            
            {{-- Waktu Penukaran Terakhir --}}
            <div class="bg-white rounded-[6px] border border-gray-100 p-5 shadow-sm flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-sm pb-3 border-b border-gray-100">Waktu Penukaran Terakhir</h3>
                    
                    <div class="space-y-3.5 mt-3 mb-4">
                        @forelse($terakhir as $log)
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-800 truncate">{{ $log->nama }} ({{ $log->departemen }})</p>
                                    <p class="text-[9px] text-gray-400 font-bold mt-0.5">
                                        {{ \Carbon\Carbon::parse($log->waktu_tukar)->format('d M Y - H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-6 font-semibold">Belum ada riwayat penukaran kupon.</p>
                        @endforelse
                    </div>

                    {{-- Pagination & Rows Per Page --}}
                    <div class="border-t border-gray-100 pt-4 flex flex-col gap-3">
                        <div class="flex items-center justify-between text-[10px] font-semibold text-gray-500">
                            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-1 m-0">
                                @foreach(request()->except(['per_page', 'dashboard_page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <span>Tampil</span>
                                <select name="per_page" onchange="this.form.submit()" class="px-1 py-0.5 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-emerald-500 bg-gray-50 text-[10px] font-bold text-gray-700 cursor-pointer">
                                    <option value="5" {{ request('per_page') == '5' ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page', '5') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                </select>
                            </form>
                            <div>
                                {{ $terakhir->firstItem() ?? 0 }}-{{ $terakhir->lastItem() ?? 0 }} dr {{ $terakhir->total() }}
                            </div>
                        </div>
                        <div>
                            {{ $terakhir->appends(request()->query())->links('vendor.pagination.custom-link') }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
