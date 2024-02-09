<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\OpsiJabawan;
use App\Models\Admin\Soal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index()
    {
        return view("");
    }

    public function kejuruan()
    {
        $data = Soal::with('opsiJawaban')->where('kategori_soal', 'kejuruan')->get();
        return view("admin.data_soal.kejuruan.index", [
            "data"=> $data
        ]);
    }

    public function psikotes()
    {
        $data = Soal::where('kategori_soal', 'psikotes')->get();
        return view("admin.data_soal.psikotes.index", [
            "data"=> $data
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $soal = new Soal();
        $soal->tipe_soal = $request->tipe;
        $soal->pertanyaan = $request->pertanyaan;
        $soal->kategori_soal = $request->kategori;
        $soal->level_soal = $request->level;
        $soal->save();

        $soal_id = $soal->id;
        foreach ($request->pg as $k => $v) {
            $opsi_jawaban = new OpsiJabawan();
            $opsi_jawaban->soal_id = $soal_id;
            $opsi_jawaban->opsi_jawaban = $v;
            if( $request->jawaban == 'a' && $k == 0){
                $opsi_jawaban->is_jawaban = 1;
            }elseif( $request->jawaban == 'b' && $k == 1){
                $opsi_jawaban->is_jawaban = 1;
            }elseif( $request->jawaban == 'c' && $k == 2){
                $opsi_jawaban->is_jawaban = 1;
            }elseif( $request->jawaban == 'd' && $k == 3){
                $opsi_jawaban->is_jawaban = 1;
            }else{
                $opsi_jawaban->is_jawaban = 0;
            }
            $opsi_jawaban->save();
        }

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Data berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $soal = Soal::find($id);
        $soal->update([
            'tipe_soal' => $request->tipe,
            'pertanyaan' => $request->pertanyaan,
            'kategori_soal' => $request->kategori,
            'level_soal' => $request->level
        ]);

        foreach($request->id_jawaban as $k => $v){
            if( $request->jawaban == 'a' && $k == 0){
                $jawaban = 1;
            }elseif( $request->jawaban == 'b' && $k == 1){
                $jawaban = 1;
            }elseif( $request->jawaban == 'c' && $k == 2){
                $jawaban = 1;
            }elseif( $request->jawaban == 'd' && $k == 3){
                $jawaban = 1;
            }else{
                $jawaban = 0;
            }

            $opsi_jawaban= OpsiJabawan::find($v);
            $opsi_jawaban->update([
                'opsi_jawaban' => $request->pg[$k],
                'is_jawaban' => $jawaban
            ]);
        }

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Data berhasil diubah!'
        ]);
    }

    public function destroy($id)
    {
        dd($id);
        Soal::where('id', $id)->delete();
        return redirect()->back()->with([
            'success' => true,
            'message'=> 'Data soal berhasil di hapus!'
        ]);
    }
}
