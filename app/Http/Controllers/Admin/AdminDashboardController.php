<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index() : object
    {
        // count data siswa
        $siswaCounter = DB::table('m_siswa')->count();
        // count siswa has answered the test
        $siswaAnswered = DB::table('m_hasil_tes')->select('user_id')->distinct()->get();
        $data = [
            'siswa_counter' => $siswaCounter,
            'siswa_answered' => count($siswaAnswered)
        ];
        return view('admin.index', $data);
    }
}
