<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Soal;
use App\Models\HasilTes;
use App\Models\StartTest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Siswa;
use stdClass;

class QuestionController extends Controller
{
    public function index()
    {
        $user_login = auth()->user()->id;
        $has_start_test_kejuruan = StartTest::where([
            'user_id' => $user_login,
            'jenis_soal' => 'kejuruan',
            'is_submit' => 1
            ])->first();

        $has_start_test_psikotes = StartTest::where([
            'user_id' => $user_login,
            'jenis_soal' => 'psikotes',
            'is_submit' => 1
            ])->first();

        return view("user.question.index", [
            'user_login' => $user_login,
            'has_start_test_kejuruan' => $has_start_test_kejuruan,
            'has_start_test_psikotes' => $has_start_test_psikotes
        ]);
    }

    public function startTest(Request $request)
    {
        $user_login = auth()->user()->id;
        
        $start_test = new StartTest();
        $start_test->user_id = $user_login;
        $start_test->jenis_soal = $request->jenis_tes;
        $start_test->start_test = Carbon::now()->format('Y-m-d H:i:s');;
        $start_test->end_test = null;
        $start_test->is_submit = 0;
        $start_test->save();

        return response()->json([
            'success' => true,
            'data' => $start_test
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
        $soal = Soal::with('opsiJawaban')->where('kategori_soal', 'kejuruan')->paginate(10);
        $soal_count = Soal::where('kategori_soal', 'kejuruan')->count();
        return view('user.question.kejuruan', [
            'soal' => $soal,
            'soal_count' => $soal_count
        ]);
    }

    function hasilTes(Request $request)
    {
        if($request->jenis_tes == "psikotes") {
            $user_login = auth()->user()->id;
        
            $start_test = new StartTest();
            $start_test->user_id = $user_login;
            $start_test->jenis_soal = "kejuruan";
            $start_test->start_test = Carbon::now()->format('Y-m-d H:i:s');;
            $start_test->end_test = null;
            $start_test->is_submit = 0;
            $start_test->save();
        }

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

        // update start test
        $start_test = StartTest::where([
            'user_id' => $request->user_id,
            'jenis_soal' => $request->jenis_tes
        ])->first();
        
        $start_test->is_submit = 1;
        $start_test->end_test = Carbon::now()->format('Y-m-d H:i:s');;
        $start_test->save();

        if($request->jenis_tes == 'psikotes') {
            return redirect()->route('kejuruan')->with([
                'success' => true,
                'message' => 'Anda akan diarahkan ke soal berikutnya, soal test kejuruan.'
            ]);
        }else if($request->jenis_tes == 'kejuruan') {
            return redirect()->route('userDashboard')->with([
                'success' => true,
                'message' => 'Anda telah melakukan semua tes.'
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

    public function hasilTesKejuruan()
    {
        $nilai_siswa = [];

        $soal_jawaban = HasilTes::with(['soal', 'opsiJawaban', 'user'])
        ->where('jenis_soal', 'kejuruan')
        ->get();
        
        $soal_count = Soal::where('kategori_soal', 'kejuruan')->count();

        $user = User::with(['startTest' => function($query) {
            $query->where('jenis_soal', 'kejuruan');
        }])->get();
        
        foreach($user as $u) {
            $jawaban_benar_count = HasilTes::with(['soal', 'opsiJawaban'])
                ->where([
                    'user_id' => $u->id,
                    'jenis_soal' => 'kejuruan',
                    'is_benar' => '1'
                ])->count();

            if(!empty($u->siswa_id)) {
                $siswa = Siswa::where('id', $u->siswa_id)->first();

                $nilai = ($jawaban_benar_count/$soal_count) * 100;

                $items = new stdClass();
                $items->id = $u->id;
                $items->siswa = $siswa->nama;
                $items->tipe_soal = 'kejuruan';
                $items->nilai = $nilai;
                $items->is_done = !empty($u->startTest->first()->is_submit) ? 1 : 0;

                array_push($nilai_siswa, $items);
            }
        }

        return view('admin.hasil_tes.kejuruan', [
            'soal_jawaban' => $soal_jawaban,
            'jawaban_benar_count' => $jawaban_benar_count,
            'nilai_siswa' => $nilai_siswa
        ]);
    }

    public function hasilTesPsikotes()
    {
        $nilai_siswa = [];
    
        $soal_jawaban = HasilTes::with(['soal', 'opsiJawaban', 'user'])
            ->where('jenis_soal', 'psikotes')
            ->get();
        
        $soal_count = Soal::where('kategori_soal', 'psikotes')->count();
    
        $user = User::with(['startTest' => function($query) {
            $query->where('jenis_soal', 'psikotes');
        }])->get();
        
        foreach($user as $u) {
            $jawaban_benar_count = HasilTes::with(['soal', 'opsiJawaban'])
                ->where([
                    'user_id' => $u->id,
                    'jenis_soal' => 'psikotes',
                    'is_benar' => '1'
                ])->count();
    
            if(!empty($u->siswa_id)) {
                $siswa = Siswa::where('id', $u->siswa_id)->first();
    
                $nilai = ($jawaban_benar_count / $soal_count) * 100;
    
                $items = new stdClass();
                $items->id = $u->id;
                $items->siswa = $siswa->nama;
                $items->tipe_soal = 'psikotes';
                $items->nilai = $nilai;
                $items->is_done = !empty($u->startTest->first()->is_submit) ? 1 : 0;
    
                array_push($nilai_siswa, $items);
            }
        }
    
        return view('admin.hasil_tes.psikotes', [
            'soal_jawaban' => $soal_jawaban,
            'jawaban_benar_count' => $jawaban_benar_count,
            'nilai_siswa' => $nilai_siswa
        ]);
    }
}
