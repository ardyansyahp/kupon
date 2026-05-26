@extends('layouts.admin')

@section('content')
<div class="fade-in space-y-6 max-w-full">
    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Semua Karyawan</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Import &rsaquo; Semua Karyawan</p>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success') || session('error') || $errors->any())
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="{{ session('success') ? 'bg-emerald-50 border-emerald-100 text-emerald-700' : 'bg-red-50 border-red-100 text-red-700' }} border px-4 py-3 rounded-[6px] shadow-sm flex justify-between items-center relative z-50">
            <span>
                <span class="font-bold text-xs">{{ session('success') ?? session('error') }}</span>
                @if($errors->any())
                    <ul class="list-disc list-inside text-[11px] mt-1 font-semibold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </span>
            <button @click="show = false" class="text-current opacity-55 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-[6px] shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Section 1: Upload File --}}
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm pb-2 border-b border-gray-100">
                    1. Upload File Excel (.xlsx)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">File Excel (.xlsx)</label>
                        <input type="file" name="file" accept=".xlsx"
                            class="block w-full text-xs text-gray-500 file:mr-3.5 file:py-2 file:px-3 file:rounded-[6px] file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                            required>
                        <p class="mt-1.5 text-[10px] text-gray-400 font-semibold">Mendukung format .xlsx (max 4MB)</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Mulai dari Baris ke-</label>
                        <input type="number" name="start_row" value="2" min="1"
                            class="w-32 rounded-[6px] border border-gray-200 px-3.5 py-2 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner"
                            required>
                        <p class="mt-1.5 text-[10px] text-gray-400 font-semibold">Abaikan baris header (biasanya baris 1)</p>
                    </div>
                </div>
            </div>

            {{-- Section 2: Column Mapping --}}
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm pb-2 border-b border-gray-100">
                    2. Mapping Kolom (Huruf Kolom Excel)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center h-10 w-full border border-gray-200 rounded-[6px] overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all">
                            <span class="bg-gray-50 text-gray-500 px-3 flex items-center h-full text-[9px] font-bold tracking-wider uppercase select-none border-r border-gray-200">Kolom</span>
                            <input type="text" name="col_nik" placeholder="A" class="uppercase flex-1 h-full px-3 border-0 focus:ring-0 focus:outline-none font-mono text-xs bg-white" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Nama Karyawan <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center h-10 w-full border border-gray-200 rounded-[6px] overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all">
                            <span class="bg-gray-50 text-gray-500 px-3 flex items-center h-full text-[9px] font-bold tracking-wider uppercase select-none border-r border-gray-200">Kolom</span>
                            <input type="text" name="col_nama" placeholder="B" class="uppercase flex-1 h-full px-3 border-0 focus:ring-0 focus:outline-none font-mono text-xs bg-white" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Departemen <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center h-10 w-full border border-gray-200 rounded-[6px] overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all">
                            <span class="bg-gray-50 text-gray-500 px-3 flex items-center h-full text-[9px] font-bold tracking-wider uppercase select-none border-r border-gray-200">Kolom</span>
                            <input type="text" name="col_departemen" placeholder="C" class="uppercase flex-1 h-full px-3 border-0 focus:ring-0 focus:outline-none font-mono text-xs bg-white" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Plant <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center h-10 w-full border border-gray-200 rounded-[6px] overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all">
                            <span class="bg-gray-50 text-gray-500 px-3 flex items-center h-full text-[9px] font-bold tracking-wider uppercase select-none border-r border-gray-200">Kolom</span>
                            <input type="text" name="col_plant" placeholder="D" class="uppercase flex-1 h-full px-3 border-0 focus:ring-0 focus:outline-none font-mono text-xs bg-white" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="flex items-center h-10 w-full border border-gray-200 rounded-[6px] overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all">
                            <span class="bg-gray-50 text-gray-500 px-3 flex items-center h-full text-[9px] font-bold tracking-wider uppercase select-none border-r border-gray-200">Kolom</span>
                            <input type="text" name="col_jeniskelamin" placeholder="E" class="uppercase flex-1 h-full px-3 border-0 focus:ring-0 focus:outline-none font-mono text-xs bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Status <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="flex items-center h-10 w-full border border-gray-200 rounded-[6px] overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all">
                            <span class="bg-gray-50 text-gray-500 px-3 flex items-center h-full text-[9px] font-bold tracking-wider uppercase select-none border-r border-gray-200">Kolom</span>
                            <input type="text" name="col_status" placeholder="F" class="uppercase flex-1 h-full px-3 border-0 focus:ring-0 focus:outline-none font-mono text-xs bg-white">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="bg-[#137333] hover:bg-green-800 text-white px-5 py-2.5 rounded-[6px] transition-colors flex items-center gap-2 font-bold text-xs uppercase tracking-wider shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Import Data Karyawan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('input[name^="col_"]').forEach(input => {
        const saved = localStorage.getItem(`kupon_${input.name}`);
        if (saved && !input.value) input.value = saved;
        input.addEventListener('change', () => {
            localStorage.setItem(`kupon_${input.name}`, input.value.toUpperCase());
        });
    });
</script>
@endsection
