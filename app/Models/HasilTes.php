<?php

namespace App\Models;

use App\Models\Admin\OpsiJabawan;
use App\Models\Admin\Soal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    use HasFactory;

    protected $table = 'm_hasil_tes';
    protected $guarded = ['id'];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }

    public function opsiJawaban()
    {
        return $this->belongsTo(OpsiJabawan::class, 'opsi_jawaban_id', 'id');
    }
}
