<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiJabawan extends Model
{
    use HasFactory;
    protected $table = 'm_opsi_jawaban';
    protected $guarded = ['id'];
}
