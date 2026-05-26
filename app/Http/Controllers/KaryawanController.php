<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index($plant)
    {
        // Define themes mapping
        $themes = [
            '1' => ['primary' => 'red-600', 'hover' => 'red-700', 'light' => 'red-50', 'text' => 'red-800'],
            '3' => ['primary' => 'green-600', 'hover' => 'green-700', 'light' => 'green-50', 'text' => 'green-800'],
            '4' => ['primary' => 'blue-600', 'hover' => 'blue-700', 'light' => 'blue-50', 'text' => 'blue-800'],
        ];

        // Default to green if plant is invalid
        $theme = $themes[$plant] ?? $themes['3'];
        
        // Extract numeric plant id if needed (assuming URL passes '1', '3', '4' directly)
        $plantId = str_replace('plant-', '', $plant); 
        // fallback in case they pass 'plant-1' instead of '1'
        if(isset($themes[$plantId])){
            $theme = $themes[$plantId];
        }

        return view('tukar', compact('plantId', 'theme'));
    }

    public function search(Request $request, $plant)
    {
        $q = $request->query('q');
        $plantId = str_replace('plant-', '', $plant);

        if (!$q || strlen($q) < 3) {
            return response()->json([]);
        }

        $karyawans = Karyawan::where('plant', $plantId)
            ->where(function ($query) use ($q) {
                $query->where('nik', 'like', "%{$q}%")
                      ->orWhere('nama', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get();

        return response()->json($karyawans);
    }

    public function prosesTukar(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:karyawans,id'
        ]);

        $karyawan = Karyawan::find($request->id);
        
        if (!in_array($karyawan->status_tukar, ['belum', 'ditolak'])) {
            return response()->json(['error' => 'Kupon ini sudah diproses.'], 400);
        }

        $karyawan->update([
            'status_tukar' => 'menunggu',
            'waktu_tukar' => now(),
        ]);

        return response()->json(['success' => true, 'karyawan' => $karyawan]);
    }

    public function prosesTukarBaru(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'status'    => 'nullable|string|max:255',
            'qty_ambil' => 'required|integer|min:1|max:20',
            'plant'     => 'required|in:1,3,4',
        ]);

        // Generate a unique walk-in NIK
        $nik = 'WALK-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

        $karyawan = Karyawan::create([
            'nik'         => $nik,
            'nama'        => trim($request->nama),
            'departemen'  => 'Walk-in',
            'plant'       => $request->plant,
            'status'      => $request->status ?? 'Walk-in',
            'qty_ambil'   => $request->qty_ambil,
            'is_walkin'   => true,
            'status_tukar'=> 'menunggu',
            'waktu_tukar' => now(),
        ]);

        return response()->json(['success' => true, 'karyawan' => $karyawan]);
    }
}
