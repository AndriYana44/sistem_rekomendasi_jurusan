<?php

namespace App\Http\Controllers;

use App\Models\Admin\Siswa;
use App\Models\NilaiUN;
use Illuminate\Http\Request;

class NilaiUNController extends Controller
{
    public function index()
    {
        $data = NilaiUN::with(['siswa'])->get();
        $siswa = Siswa::all();
        return view('admin.nilai_rapot.nilai_un.index', [
            'data' => $data,
            'siswa' => $siswa
        ]);
    }

    public function store(Request $request)
    {
        $UN = new NilaiUN();
        $UN->siswa_id = $request->siswa;
        $UN->mapel = $request->mapel;
        $UN->nilai = $request->nilai;
        $UN->save();

        return redirect('admin/data-nilai-un')->with([
            'success' => true,
            'message' => 'Data nilai UN berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $UN = NilaiUN::find($id);
        $UN->siswa_id = $request->siswa;
        $UN->mapel = $request->mapel;
        $UN->nilai = $request->nilai;
        $UN->update();

        return redirect('admin/data-nilai-un')->with([
            'success' => true,
            'message' => 'Data nilai UN berhasil diubah!'
        ]);
    }
    public function delete($id)
    {
        NilaiUN::find($id)->delete();
        return redirect('admin/data-nilai-un')->with([
            'success' => true,
            'message' => 'Data nilai UN berhasil dihapus!'
        ]);
    }
}
