<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Siswa;
use App\Models\HasilTes;
use App\Models\Kejuruan;
use App\Models\NilaiKriteria;
use App\Models\NilaiUN;
use App\Models\User;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    public function index() : object
    {
        $data = Siswa::all();
        $kejuruan = Kejuruan::all();
        return view('admin.data_siswa.index', [
            'data' => $data,
            'kejuruan' => $kejuruan
        ]);
    }

    public function store(Request $request) : object
    {
        $data = [
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'asal_sekolah' => $request->asal_sekolah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'no_telp' => $request->no_hp,
            'email' => $request->email,
        ];

        Siswa::create($data);

        // get id insert
        $id = Siswa::latest()->first()->id;
        $username = explode(' ', $request->nama);
        // join array with underscore
        $username = implode('.', $username);
        // random number
        $username = strtolower($username);
        $username .= rand(1000, 9999);
        $password = bcrypt('123456');

        // insert to table users
        $data = [
            'siswa_id' => $id,
            'name' => $request->nama,
            'username' => $username,
            'password' => $password,
            'level' => 'user',
        ];

        User::create($data);

        return redirect()->route('data-siswa')->with('success', 'Data berhasil ditambahkan');
    }

    public function destroy($id) : object
    {
        // delete data siswa
        Siswa::destroy($id);
        
        // delete user
        User::where('siswa_id', $id)->delete();

        // delete Hasil Tes
        $user = User::where('siswa_id', $id)->get();
        $hasilTes = HasilTes::where('user_id', $user[0]->id)->get();
        if($hasilTes->count() > 0) {
            foreach($hasilTes as $item) {
                $item->delete();
            }
        }

        // delete nilai kriteria
        $nilaiKriteria = NilaiKriteria::where('siswa_id', $id)->get();
        if($nilaiKriteria->count() > 0) {
            foreach($nilaiKriteria as $item) {
                $item->delete();
            }
        }

        // delete nilai un
        $nilaiUN = NilaiUN::where('siswa_id', $id)->get();
        if($nilaiUN->count() > 0) {
            foreach($nilaiUN as $item) {
                $item->delete();
            }
        }
        
        return redirect()->route('data-siswa')->with('success', 'Data berhasil dihapus');
    }
}
