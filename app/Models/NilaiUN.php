<?php

namespace App\Models;

use App\Models\Admin\Siswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiUN extends Model
{
    use HasFactory;

    protected $table = 'm_nilai_un';
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
}
