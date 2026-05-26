<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    private function getActivePlant(Request $request)
    {
        if (Auth::user()->role === 'superadmin') {
            return $request->query('plant_filter', 'all');
        }
        return Auth::user()->plant;
    }

    private function baseQuery($plant)
    {
        $query = Karyawan::query();
        if ($plant !== 'all') {
            $query->where('plant', $plant);
        }
        return $query;
    }

    public function index(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $perPageDashboard = $request->input('per_page', 5);

        // Metrics
        $totalKaryawan = $this->baseQuery($activePlant)->count();
        $menunggu = $this->baseQuery($activePlant)->where('status_tukar', 'menunggu')->count();
        $sudahDitukar = $this->baseQuery($activePlant)->where('status_tukar', 'sudah')->count();
        $belumDitukar = $this->baseQuery($activePlant)->whereIn('status_tukar', ['belum', 'ditolak'])->count();

        $terakhir = $this->baseQuery($activePlant)
            ->where('status_tukar', 'sudah')
            ->orderBy('waktu_tukar', 'desc')
            ->paginate($perPageDashboard, ['*'], 'dashboard_page')
            ->appends($request->all());
        
        return view('admin.dashboard', compact('activePlant', 
            'totalKaryawan', 'menunggu', 'sudahDitukar', 'belumDitukar', 'terakhir'
        ));
    }

    public function daftarTukar(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $perPageTunggu = $request->input('per_page_tunggu', 10);
        $perPageRiwayat = $request->input('per_page_riwayat', 10);

        // Data Tables
        $queryTunggu = $this->baseQuery($activePlant)->where('status_tukar', 'menunggu')->orderBy('waktu_tukar', 'desc');
        $queryRiwayat = $this->baseQuery($activePlant)->whereIn('status_tukar', ['sudah', 'ditolak'])->orderBy('waktu_konfirmasi', 'desc');
        
        if ($request->search) {
            $queryTunggu->where(function($q) use ($request) {
                $q->where('nik', 'like', "%{$request->search}%")
                  ->orWhere('nama', 'like', "%{$request->search}%");
            });
            $queryRiwayat->where(function($q) use ($request) {
                $q->where('nik', 'like', "%{$request->search}%")
                  ->orWhere('nama', 'like', "%{$request->search}%");
            });
        }

        if ($request->search_tunggu) {
            $queryTunggu->where(function($q) use ($request) {
                $q->where('nik', 'like', "%{$request->search_tunggu}%")
                  ->orWhere('nama', 'like', "%{$request->search_tunggu}%");
            });
        }

        if ($request->search_riwayat) {
            $queryRiwayat->where(function($q) use ($request) {
                $q->where('nik', 'like', "%{$request->search_riwayat}%")
                  ->orWhere('nama', 'like', "%{$request->search_riwayat}%");
            });
        }

        $daftarTunggu = $queryTunggu->paginate($perPageTunggu, ['*'], 'tunggu_page')->appends($request->all());
        $riwayat = $queryRiwayat->paginate($perPageRiwayat, ['*'], 'riwayat_page')->appends($request->all());

        return view('admin.daftar_tukar', compact('daftarTunggu', 'riwayat', 'activePlant'));
    }

    public function accept($id)
    {
        if (Auth::user()->role === 'superadmin') {
            $karyawan = Karyawan::findOrFail($id);
        } else {
            $karyawan = Karyawan::where('plant', Auth::user()->plant)->findOrFail($id);
        }
        $karyawan->update([
            'status_tukar' => 'sudah',
            'waktu_konfirmasi' => now(),
            'admin_id' => Auth::id()
        ]);

        return back()->with('success', 'Kupon atas nama ' . $karyawan->nama . ' berhasil diterima.');
    }

    public function reject($id)
    {
        if (Auth::user()->role === 'superadmin') {
            $karyawan = Karyawan::findOrFail($id);
        } else {
            $karyawan = Karyawan::where('plant', Auth::user()->plant)->findOrFail($id);
        }
        $karyawan->update([
            'status_tukar' => 'ditolak',
            'waktu_konfirmasi' => now(),
            'admin_id' => Auth::id()
        ]);

        return back()->with('success', 'Kupon atas nama ' . $karyawan->nama . ' telah ditolak.');
    }

    public function export(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $karyawan = $this->baseQuery($activePlant)->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $columns = ['NIK', 'Nama', 'Departemen', 'Plant', 'Jenis Kelamin', 'Status', 'Status Tukar', 'Waktu Tukar', 'Waktu Konfirmasi'];
        foreach ($columns as $colIndex => $colName) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '1', $colName);
        }
        
        foreach ($karyawan as $rowIndex => $row) {
            $rowNum = $rowIndex + 2;
            $sheet->setCellValue('A' . $rowNum, $row->nik);
            $sheet->setCellValue('B' . $rowNum, $row->nama);
            $sheet->setCellValue('C' . $rowNum, $row->departemen);
            $sheet->setCellValue('D' . $rowNum, $row->plant);
            $sheet->setCellValue('E' . $rowNum, $row->jeniskelamin);
            $sheet->setCellValue('F' . $rowNum, $row->status);
            $sheet->setCellValue('G' . $rowNum, ucfirst($row->status_tukar));
            $sheet->setCellValue('H' . $rowNum, $row->waktu_tukar);
            $sheet->setCellValue('I' . $rowNum, $row->waktu_konfirmasi);
        }

        // Auto-fit columns
        foreach (range(1, count($columns)) as $col) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $filename = "rekap_qurban_plant_{$activePlant}_" . date('Y-m-d') . ".xlsx";

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function tambahKaryawanForm()
    {
        return view('admin.tambah_karyawan');
    }

    public function tambahKaryawanStore(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:karyawans,nik',
            'nama' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'plant' => 'required|string|in:1,3,4',
            'jeniskelamin' => 'nullable|string|in:M,F',
            'status' => 'nullable|string|max:255',
        ]);

        Karyawan::create([
            'nik' => trim($request->nik),
            'nama' => trim($request->nama),
            'departemen' => trim($request->departemen),
            'plant' => $request->plant,
            'jeniskelamin' => $request->jeniskelamin,
            'status' => trim($request->status),
            'status_tukar' => 'belum',
        ]);

        return back()->with('success', 'Karyawan dengan NIK ' . $request->nik . ' berhasil ditambahkan secara manual.');
    }

    public function listKaryawan(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $perPage = $request->input('per_page', 15);
        $query = $this->baseQuery($activePlant)->orderBy('nama', 'asc');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nik', 'like', "%{$request->search}%")
                  ->orWhere('nama', 'like', "%{$request->search}%")
                  ->orWhere('departemen', 'like', "%{$request->search}%");
            });
        }

        if ($request->jeniskelamin) {
            $query->where('jeniskelamin', $request->jeniskelamin);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $karyawans = $query->paginate($perPage)->appends($request->all());

        // Get unique gender and status options for dropdown filters
        $genderOptions = $this->baseQuery($activePlant)->whereNotNull('jeniskelamin')->where('jeniskelamin', '!=', '')->distinct()->pluck('jeniskelamin');
        $statusOptions = $this->baseQuery($activePlant)->whereNotNull('status')->where('status', '!=', '')->distinct()->pluck('status');

        return view('admin.list_karyawan', compact('karyawans', 'genderOptions', 'statusOptions', 'activePlant'));
    }

    public function updateKaryawan(Request $request, $id)
    {
        $query = Karyawan::query();
        if (Auth::user()->role !== 'superadmin') {
            $query->where('plant', Auth::user()->plant);
        }
        $karyawan = $query->findOrFail($id);

        $request->validate([
            'nik' => 'required|string|unique:karyawans,nik,' . $id,
            'nama' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'jeniskelamin' => 'nullable|string|in:M,F',
            'status' => 'nullable|string|max:255',
        ]);

        $karyawan->update([
            'nik' => trim($request->nik),
            'nama' => trim($request->nama),
            'departemen' => trim($request->departemen),
            'jeniskelamin' => $request->jeniskelamin,
            'status' => trim($request->status),
        ]);

        return back()->with('success', 'Profil karyawan ' . $karyawan->nama . ' berhasil diperbarui.');
    }

    public function deleteKaryawan($id)
    {
        $query = Karyawan::query();
        if (Auth::user()->role !== 'superadmin') {
            $query->where('plant', Auth::user()->plant);
        }
        $karyawan = $query->findOrFail($id);
        $nama = $karyawan->nama;
        $karyawan->delete();

        return back()->with('success', 'Karyawan ' . $nama . ' berhasil dihapus dari database.');
    }

    public function deleteAllKaryawan(Request $request)
    {
        $activePlant = $this->getActivePlant($request);
        $this->baseQuery($activePlant)->delete();

        if ($activePlant === 'all') {
            return back()->with('success', 'Semua data karyawan berhasil dihapus.');
        } else {
            return back()->with('success', 'Semua data karyawan dari Plant ' . $activePlant . ' berhasil dihapus.');
        }
    }
}
