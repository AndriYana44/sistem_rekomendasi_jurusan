<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Soal;
use App\Models\HasilTes;
use App\Models\StartTest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return view("user.question.index");
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
        $soal = Soal::with('opsiJawaban')->where('kategori_soal', 'kejuruan')->paginate(10);
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

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Anda akan diarahkan ke soal berikutnya, soal test kejuruan.'
        ]);
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
