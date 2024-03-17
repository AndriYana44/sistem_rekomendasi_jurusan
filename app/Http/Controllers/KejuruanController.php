<?php

namespace App\Http\Controllers;

use App\Models\Kejuruan;
use Illuminate\Http\Request;

class KejuruanController extends Controller
{
    public function index()
    {
        $data = Kejuruan::all();
        return view('admin.data_kejuruan.index', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $kejuruan = new Kejuruan();
        $kejuruan->kejuruan = strtoupper($request->jurusan);
        $kejuruan->save();

        return redirect('admin/data-kejuruan')->with([
            'success' => true,
            'message' => 'Data kejuruan berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $kejuruan = Kejuruan::find($id);
        $kejuruan->kejuruan = strtoupper($request->jurusan);
        $kejuruan->update();  
        
        return redirect('admin/data-kejuruan')->with([
            'success' => true,
            'message' => 'Data kejuruan berhasil diupdate!'
        ]);
    }

    public function delete($id)
    {
        Kejuruan::find($id)->delete();

        return redirect('admin/data-kejuruan')->with([
            'success' => true,
            'message' => 'Data kejuruan berhasil dihapus!'
        ]);
    }
}
