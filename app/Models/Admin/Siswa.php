<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // table
    protected $table = 'm_siswa';

    // fillable
    protected $fillable = [
        'nisn',
        'nama',
        'alamat',
        'asal_sekolah',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tgl_lahir',
        'no_telp',
        'email',
    ];
}
