<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    // join to user
    public function user()
    {
        return $this->hasOne(User::class, 'siswa_id', 'id');
    }
}
