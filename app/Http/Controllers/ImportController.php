<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx|max:4096',
            'start_row' => 'required|integer|min:1',
            'col_nik' => 'required|string|size:1',
            'col_nama' => 'required|string|size:1',
            'col_departemen' => 'required|string|size:1',
            'col_plant' => 'required|string|size:1',
            'col_jeniskelamin' => 'nullable|string|size:1',
            'col_status' => 'nullable|string|size:1',
        ]);

        $file = $request->file('file');
        $startRow = $request->input('start_row');
        
        $colNik = ord(strtoupper($request->input('col_nik'))) - 65;
        $colNama = ord(strtoupper($request->input('col_nama'))) - 65;
        $colDept = ord(strtoupper($request->input('col_departemen'))) - 65;
        $colPlant = ord(strtoupper($request->input('col_plant'))) - 65;
        
        $colJK = $request->input('col_jeniskelamin') ? (ord(strtoupper($request->input('col_jeniskelamin'))) - 65) : null;
        $colStatus = $request->input('col_status') ? (ord(strtoupper($request->input('col_status'))) - 65) : null;

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            DB::beginTransaction();
            foreach ($rows as $index => $data) {
                $rowNumber = $index + 1; // 1-indexed
                if ($rowNumber >= $startRow) {
                    if (isset($data[$colNik]) && trim($data[$colNik]) !== '') {
                        Karyawan::updateOrCreate(
                            ['nik' => trim($data[$colNik])],
                            [
                                'nama' => isset($data[$colNama]) ? trim($data[$colNama]) : '',
                                'departemen' => isset($data[$colDept]) ? trim($data[$colDept]) : '',
                                'plant' => isset($data[$colPlant]) ? trim($data[$colPlant]) : '',
                                'jeniskelamin' => ($colJK !== null && isset($data[$colJK])) ? trim($data[$colJK]) : null,
                                'status' => ($colStatus !== null && isset($data[$colStatus])) ? trim($data[$colStatus]) : null,
                            ]
                        );
                    }
                }
            }
            DB::commit();
            return back()->with('success', 'Data karyawan berhasil diimport dari file Excel (.xlsx).');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
