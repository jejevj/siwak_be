<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuser extends Model
{
    use HasFactory;

    protected $table = 'tuser'; // Table name

    // Set the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'user_fullname',
        'user_password',
        'user_grup',
        'list_office',
        'approve',
        'profpict',
        'gender',
        'notelp',
        'alamat',
        'email',
        'remarks',
        'jabatan_nama',
        'jabatan_tmt',
        'golongan_abbr',
        'is_subscribe',
        'is_surveyor',
        'provinsi_kode',
        'kabkota_kode',
    ];
}
