<?php

namespace App\Models;

use App\Models\Admin\Siswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKriteria extends Model
{
    use HasFactory;

    protected $table = 'm_nilai_kriteria';
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function kejuruan()
    {
        return $this->belongsTo(Kejuruan::class, 'jurusan_id', 'id');
    }
}
