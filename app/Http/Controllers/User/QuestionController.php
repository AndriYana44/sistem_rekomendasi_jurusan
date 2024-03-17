<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Soal;
use App\Models\HasilTes;
use App\Models\StartTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $userExist = DB::table('m_hasil_tes')
                    ->where('user_id', $user_id)
                    ->count();
        
        $soal_access = !$userExist ? true : false;

        return view("user.question.index", [
            'soal_access' => $soal_access
        ]);
    }

    public function psikotes(Request $request)
    {
        $soal = Soal::with('opsiJawaban')->where('kategori_soal', 'psikotes')->get();
        $soal_count = Soal::where('kategori_soal', 'psikotes')->count();
        return view("user.question.psikotes", [
            'soal' => $soal,
            'soal_count' => $soal_count
        ]);
    }

    public function kejuruan()
    {
        $soal = Soal::with('opsiJawaban')->where('kategori_soal', 'kejuruan')->get();
        $soal_count = Soal::where('kategori_soal', 'kejuruan')->count();
        return view('user.question.kejuruan', [
            'soal' => $soal,
            'soal_count' => $soal_count
        ]);
    }

    function hasilTes(Request $request)
    {
        foreach($request->id_soal as $val) {
            $psikotes = new HasilTes();
            $psikotes->user_id = $request->user_id;
            $psikotes->soal_id = $val;
            $psikotes->opsi_jawaban_id = $request->$val == null ? 0 : $request->$val[0];
            $psikotes->jenis_soal = $request->jenis_tes;

            $jawaban = Soal::with(['opsiJawaban'])->where('id', $val)->get();
            foreach($jawaban->first()->opsiJawaban as $j) {
                if($request->$val != null) {
                    if($j->id == $request->$val[0]) {
                        $is_benar = $j->is_jawaban;
                    }
                }else {
                    $is_benar = 0;
                }
            }

            $psikotes->is_benar = $is_benar;
            $psikotes->save();
        } 

        if($request->jenis_tes == 'psikotes') {
            return redirect('/question/kejuruan')->with([
                'success' => true,
                'message' => 'soal test kejuruan.'
            ]);
        }else{
            return redirect('/')->with([
                'success' => true,
                'message' => 'Anda telah mengisi semua soal.'
            ]);
        }
    }

    public function setTempStartQuestions(Request $request)
    {
        $data = new StartTest();
        $data->user_id = $request->user_id;
        $data->start_test = $request->start_test;
        $data->end_test = $request->end_test;
        $data->is_submit = $request->is_submit;
        $data->save();

        return response()->json([
            'success' => true,
            'data'=> $data,
        ]);
    }
}
