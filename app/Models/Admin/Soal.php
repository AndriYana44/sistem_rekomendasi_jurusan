<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = "m_soal";
    protected $guarded = ['id'];

    public function opsiJawaban()
    {
        return $this->hasMany(OpsiJabawan::class, 'soal_id', 'id');
    }
}
