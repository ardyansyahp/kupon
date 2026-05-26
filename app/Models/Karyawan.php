<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'departemen',
        'plant',
        'jeniskelamin',
        'status',
        'qty_ambil',
        'is_walkin',
        'status_tukar',
        'waktu_tukar',
        'waktu_konfirmasi',
        'admin_id',
    ];
}
