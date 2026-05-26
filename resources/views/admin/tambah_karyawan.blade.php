@extends('layouts.admin')

@section('content')
<div class="fade-in space-y-6 max-w-full">
    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Tambah Karyawan</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Karyawan &rsaquo; Tambah Karyawan (Manual)</p>
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

    {{-- Form Container --}}
    <div class="bg-white rounded-[6px] shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.karyawan.store') }}" method="POST" class="space-y-6">
            @csrf

            <h3 class="font-extrabold text-gray-800 text-sm pb-2 border-b border-gray-100">
                Form Input Profil Karyawan Baru
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- NIK --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        NIK (Nomor Induk Karyawan) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik" placeholder="Contoh: NIK12345" value="{{ old('nik') }}"
                        class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2.5 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white"
                        required>
                    @error('nik')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" placeholder="Nama lengkap karyawan..." value="{{ old('nama') }}"
                        class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2.5 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white"
                        required>
                    @error('nama')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Departemen --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        Departemen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="departemen" placeholder="Contoh: Produksi, Maintenance, HRD..." value="{{ old('departemen') }}"
                        class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2.5 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white"
                        required>
                    @error('departemen')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Plant --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        Plant <span class="text-red-500">*</span>
                    </label>
                    <select name="plant"
                        class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2.5 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white font-semibold cursor-pointer">
                        <option value="1" {{ (old('plant') ?? Auth::user()->plant) == '1' ? 'selected' : '' }}>Plant 1</option>
                        <option value="3" {{ (old('plant') ?? Auth::user()->plant) == '3' ? 'selected' : '' }}>Plant 3</option>
                        <option value="4" {{ (old('plant') ?? Auth::user()->plant) == '4' ? 'selected' : '' }}>Plant 4</option>
                    </select>
                    @error('plant')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <select name="jeniskelamin"
                        class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2.5 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white font-semibold cursor-pointer">
                        <option value="" {{ old('jeniskelamin') === null ? 'selected' : '' }}>-- Pilih Jenis Kelamin --</option>
                        <option value="M" {{ old('jeniskelamin') == 'M' ? 'selected' : '' }}>M</option>
                        <option value="F" {{ old('jeniskelamin') == 'F' ? 'selected' : '' }}>F</option>
                    </select>
                    @error('jeniskelamin')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Karyawan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        Status Karyawan <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="text" name="status" placeholder="Contoh: Tetap, Kontrak, Outsource..." value="{{ old('status') }}"
                        class="w-full rounded-[6px] border border-gray-200 px-3.5 py-2.5 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none shadow-inner bg-white">
                    @error('status')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="bg-[#137333] hover:bg-green-800 text-white px-5 py-2.5 rounded-[6px] transition-colors flex items-center gap-2 font-bold text-xs uppercase tracking-wider shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Profil Karyawan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
