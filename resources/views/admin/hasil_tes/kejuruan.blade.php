@extends('admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Hasil Soal Tes Kejuruan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Hasil Tes kejuruan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>

    <div class="card">
        <div class="card-body py-3">
            <table class="table table-bordered table-stripped" id="datasiswa" width="100%">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Tipe Soal</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nilai_siswa as $item)
                        <tr>
                            <td>{{ $item->siswa }}</td>
                            <td>{{ $item->tipe_soal }}</td>
                            <td>{{ $item->nilai }}</td>
                            @if($item->is_done == 1)
                                <td class="text-success">Sudah</td>
                            @else
                                <td class="text-danger">Belum</td>
                            @endif
                            <td>
                                <form class="d-inline" action="{{ route('delete-soal', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" id="delete_soal">Delete</button>
                                </form>
                                <a href="#" class="btn btn-warning btn-sm editSiswa" data-bs-toggle="modal" data-bs-target="#editSiswa{{ $item->id }}">Edit</a>
                                <a href="#" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection