<?php

namespace App\Http\Controllers;

use App\Models\Admin\Siswa;
use App\Models\Kejuruan;
use App\Models\NilaiKriteria;
use Illuminate\Http\Request;

class NilaiKriteriaController extends Controller
{
    public function index()
    {
        $data = NilaiKriteria::with(['siswa', 'kejuruan'])->get();
        $siswa = Siswa::all();
        $kejuruan = Kejuruan::all();
        return view('admin.nilai_rapot.nilai_kriteria.index', [
            'data' => $data,
            'siswa' => $siswa,
            'kejuruan' => $kejuruan
        ]);
    }

    public function store(Request $request)
    {
        $kriteria = new NilaiKriteria();
        $kriteria->siswa_id = $request->siswa;
        $kriteria->jurusan_id = $request->jurusan;
        $kriteria->mapel = $request->mapel;
        $kriteria->nilai = $request->nilai;
        $kriteria->save();

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Data kriteria berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $kriteria = NilaiKriteria::find($id);
        $kriteria->siswa_id = $request->siswa;
        $kriteria->jurusan_id = $request->jurusan;
        $kriteria->mapel = $request->mapel;
        $kriteria->nilai = $request->nilai;
        $kriteria->update();

        return redirect('admin/data-nilai-kriteria')->with([
            'success' => true,
            'message' => 'Data kriteria berhasil diubah!'
        ]);
    }

    public function delete($id)
    {
        NilaiKriteria::find($id)->delete();
        return redirect('admin/data-nilai-kriteria')->with([
            'success' => true,
            'message' => 'Data kriteria berhasil dihapus!'
        ]);
    }
}
