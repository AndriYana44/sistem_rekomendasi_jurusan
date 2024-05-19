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
use App\Models\NilaiKriteria;
use stdClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $soal = Soal::with('opsiJawaban')->where('kategori_soal', 'kejuruan')->get();
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

        $user = User::with(['startTest' => function($query) {
            $query->where('jenis_soal', 'kejuruan');
        }])->get();
        
        foreach($user as $u) {
            // check user exist in table hasil tes
            $check_user = HasilTes::where(['user_id' => $u->id, 'jenis_soal' => 'kejuruan'])->first();

            $nilai = 0;
            $soal_count = 0;
            $jawaban_benar_count = 0;
            if(!empty($check_user)) {
                $soal_count += HasilTes::where([
                    'user_id' => $u->id,
                    'jenis_soal' => 'kejuruan'
                ])->count();

                $jawaban_benar_count += HasilTes::with(['soal', 'opsiJawaban'])
                    ->where([
                        'user_id' => $u->id,
                        'jenis_soal' => 'kejuruan',
                        'is_benar' => '1'
                    ])->count();
                
                $nilai = ($jawaban_benar_count / $soal_count) * 100;
            }

            if(!empty($u->siswa_id)) {
                $siswa = Siswa::where('id', $u->siswa_id)->first();

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
    
        $user = User::with(['startTest' => function($query) {
            $query->where('jenis_soal', 'psikotes');
        }])->get();
        
        foreach($user as $u) {
            // check user exist in table hasil tes
            $check_user = HasilTes::where(['user_id' => $u->id, 'jenis_soal' => 'kejuruan'])->first();

            $nilai = 0;
            $soal_count = 0;
            $jawaban_benar_count = 0;
            if(!empty($check_user)) {
                $soal_count += HasilTes::where([
                    'user_id' => $u->id,
                    'jenis_soal' => 'psikotes'
                ])->count();

                $jawaban_benar_count += HasilTes::with(['soal', 'opsiJawaban'])
                    ->where([
                        'user_id' => $u->id,
                        'jenis_soal' => 'psikotes',
                        'is_benar' => '1'
                    ])->count();
    
                $nilai = ($jawaban_benar_count / $soal_count) * 100;
            }
    
            if(!empty($u->siswa_id)) {
                $siswa = Siswa::where('id', $u->siswa_id)->first();
    
                $items = new stdClass();
                $items->id = $u->id;
                $items->siswa = $siswa->nama;
                $items->tipe_soal = 'psikotes';
                $items->nilai = round($nilai);
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

    public function deleteHasilTesKejuruan($id)
    {
        HasilTes::where(['user_id' => $id, 'jenis_soal' => 'kejuruan'])->delete();
        StartTest::where(['user_id' => $id, 'jenis_soal' => 'kejuruan'])->delete();
        return redirect()->route('hasil-tes-kejuruan')->with('success', 'Data berhasil dihapus');
    }

    public function deleteHasilTesPsikotes($id)
    {
        HasilTes::where(['user_id' => $id, 'jenis_soal' => 'psikotes'])->delete();
        StartTest::where(['user_id' => $id, 'jenis_soal' => 'psikotes'])->delete();
        return redirect()->route('hasil-tes-psikotes')->with('success', 'Data berhasil dihapus');
    }

    public function getNilaiHasilTes($tipe, $user_id, $kejuruan = null)
    {
        $soal_count = HasilTes::with(['soal', 'opsiJawaban']); 
        $soal_count->where([
            'user_id' => $user_id,
            'jenis_soal' => $tipe
        ]);
        if($kejuruan != null) {
            $soal_count->whereHas('soal', function ($query) use ($kejuruan) {
                $query->where('tipe_soal', $kejuruan);
            });
        };
        $soal_count = $soal_count->count();

        $q_jawaban_benar_count = HasilTes::with(['soal', 'opsiJawaban']);
        $q_jawaban_benar_count->where([
                'user_id' => $user_id,
                'jenis_soal' => $tipe,
                'is_benar' => '1'
        ]);

        if($kejuruan != null) {
            $q_jawaban_benar_count->whereHas('soal', function ($query) use ($kejuruan) {
                $query->where('tipe_soal', $kejuruan);
            });
        }

        $jawaban_benar_count = $q_jawaban_benar_count->count();

        // dd($jawaban_benar_count);
        return round(($jawaban_benar_count / $soal_count) * 100);
    }

    public function hasilRekomendasi()
    {
        $data = Siswa::with(['nilaiKriteria.kejuruan', 'nilaiUN', 'user.hasilTes.soal'])->get();
        $nilai_siswa = [];
        foreach($data as $d) {

            $check_user = HasilTes::where('user_id', $d->user->id)->first();

            $nilai_siswa[$d->nama]['hasil_tes_kejuruan']['tkj'] = 0;
            $nilai_siswa[$d->nama]['hasil_tes_kejuruan']['rpl'] = 0;
            $nilai_siswa[$d->nama]['hasil_tes_kejuruan']['animasi'] = 0;
            $nilai_siswa[$d->nama]['hasil_tes_psikotes'] = 0;

            if(!empty($check_user)) {
                $nilai_siswa[$d->nama]['hasil_tes_kejuruan']['tkj'] = $this->getNilaiHasilTes('kejuruan', $d->user->id, 'tkj') * 0.3;
                $nilai_siswa[$d->nama]['hasil_tes_kejuruan']['rpl'] = $this->getNilaiHasilTes('kejuruan', $d->user->id, 'rpl') * 0.3;
                $nilai_siswa[$d->nama]['hasil_tes_kejuruan']['animasi'] = $this->getNilaiHasilTes('kejuruan', $d->user->id, 'mm') * 0.3;

                $nilai_siswa[$d->nama]['hasil_tes_psikotes'] = $this->getNilaiHasilTes('psikotes', $d->user->id) * 0.2;
            }

            foreach($d->nilaiKriteria as $nk) {
                if(strtolower($nk->kejuruan->kejuruan) == 'tkj') {
                    $nilai_siswa[$d->nama]['kriteria']['tkj'][$nk->mapel] = $nk->nilai * 0.2;
                }else if(strtolower($nk->kejuruan->kejuruan) == 'rpl') {
                    $nilai_siswa[$d->nama]['kriteria']['rpl'][$nk->mapel] = $nk->nilai * 0.2;
                }else if(strtolower($nk->kejuruan->kejuruan) == 'animasi') {
                    $nilai_siswa[$d->nama]['kriteria']['animasi'][$nk->mapel] = $nk->nilai * 0.2;
                }
            }

            foreach($d->nilaiUN as $nu) {
                $nilai_siswa[$d->nama]['un'][$nu->mapel] = $nu->nilai * 0.2;
            }   

            $nilai_siswa[$d->nama]['siswa_id'] = $d->id;
        }
        
        $hasil_akhir = [];
        foreach($nilai_siswa as $key => $value) {
            $nilai_tkj = 0;
            $nilai_rpl = 0;
            $nilai_animasi = 0;
            foreach($value['kriteria']['tkj'] as $v) {
                $hasil_akhir[$key]['kriteria']['tkj'] = $nilai_tkj += $v;
            }
            foreach($value['kriteria']['rpl'] as $v) {
                $hasil_akhir[$key]['kriteria']['rpl'] = $nilai_rpl += $v;
            }
            foreach($value['kriteria']['animasi'] as $v) {
                $hasil_akhir[$key]['kriteria']['animasi'] = $nilai_animasi += $v;
            }

            $nilai_un = 0;
            foreach($value['un'] as $v) {
                $nilai_un += $v;
                $hasil_akhir[$key]['un'] = $nilai_un;
            }

            $hasil_akhir[$key]['hasil_tes_kejuruan'] = $value['hasil_tes_kejuruan'];
            $hasil_akhir[$key]['hasil_tes_psikotes'] = $value['hasil_tes_psikotes'];

            // check user exist in table hasil tes
            $user = User::where('siswa_id', $value['siswa_id'])->first();
            $check_user = HasilTes::where('user_id', $user->id)->first();
            $hasil_akhir[$key]['is_done'] = !empty($check_user) ? 1 : 0;
        }

        $rekomendasi_jurusan = [];
        foreach($hasil_akhir as $key => $value) {
            $rekomendasi_jurusan[$key]['tkj'] = $value['kriteria']['tkj'] + $value['un'] + $value['hasil_tes_kejuruan']['tkj'] + $value['hasil_tes_psikotes'];
            $rekomendasi_jurusan[$key]['rpl'] = $value['kriteria']['rpl'] + $value['un'] + $value['hasil_tes_kejuruan']['rpl'] + $value['hasil_tes_psikotes'];
            $rekomendasi_jurusan[$key]['animasi'] = $value['kriteria']['animasi'] + $value['un'] + $value['hasil_tes_kejuruan']['animasi'] + $value['hasil_tes_psikotes'];
            $rekomendasi_jurusan[$key]['is_done'] = $value['is_done'];
        }

        foreach($rekomendasi_jurusan as $key => $value) {
            $max = max($value);
            $rekomendasi_jurusan[$key]['jurusan'] = array_search($max, $value);
            $rekomendasi_jurusan[$key]['nilai_max'] = $max;
        }

        return view('admin.hasil_rekomendasi.index', [
            'hasil_akhir' => $hasil_akhir,
            'rekomendasi_jurusan' => $rekomendasi_jurusan
        ]);
    }
}
