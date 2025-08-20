<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirWakaf extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'dir_wakaf';

    // Define the primary key (if not "id")
    protected $primaryKey = 'ID_Dir';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'Lokasi_Prop', 'Lokasi_Kab', 'Lokasi_Kec', 'Lokasi_Kel', 'Lokasi_Desa',
        'Kua_Kode', 'Luas', 'Penggunaan', 'Wakif', 'Nadzir', 'pendidikan', 'Status',
        'S_No', 'S_Tgl', 'AIW_No', 'AIW_Tgl', 'Lat', 'Longi', 'Ket', 'waktu',
        'potensi_id', 'luas_bangunan', 'verifikasi', 'id_b_pemerintah', 'user_survey'
    ];

    // Define the data types (optional, but good practice)
    protected $casts = [
        'S_Tgl' => 'date',
        'AIW_Tgl' => 'date',
        'waktu' => 'datetime',
        'Lat' => 'double',
        'Longi' => 'double',
        'Luas' => 'double',
        'luas_bangunan' => 'float',
        'verifikasi' => 'int',
    ];
}
