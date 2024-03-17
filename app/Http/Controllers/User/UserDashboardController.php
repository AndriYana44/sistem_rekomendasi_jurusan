<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index() : object
    {
        $siswaAnswered = DB::table('m_hasil_tes')->select('user_id')->distinct()->get();
        $siswaCounter = DB::table('m_siswa')->count();

        $data = [
            'siswa_answered' => count($siswaAnswered),
            'siswa_counter' => $siswaCounter
        ];

        return view('user.index', [
            'data' => $data
        ]);
    }
}
