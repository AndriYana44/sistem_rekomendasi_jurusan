@extends('admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Hasil Rekomendasi Jurusan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Hasil Rekomendasi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <style>
                    th {
                        vertical-align: middle;
                    }
                </style>
                <table class="mt-4 table_hasil_rekomendasi table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25">No.</th>
                            <th width="200">Nama Siswa</th>
                            <th width="150" class="text-center">Nilai Total Weight Evaluation TKJ</th>
                            <th width="150" class="text-center">Nilai Total Weight Evaluation RPL</th>
                            <th width="150" class="text-center">Nilai Total Weight Evaluation Animasi</th>
                            <th width="100" class="text-center">Rekomendasi Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($rekomendasi_jurusan as $key => $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $key }}</td>
                                @if($item['is_done'] == 1)
                                    <td class="text-center @if($item['nilai_max'] == $item['tkj'] && $item['is_done'] == 1) bg-success text-white @endif">{{ $item['is_done'] == 1 ? strtoupper($item['tkj']) : '' }}</td>
                                    <td class="text-center @if($item['nilai_max'] == $item['rpl'] && $item['is_done'] == 1) bg-success text-white @endif">{{ $item['is_done'] == 1 ? strtoupper($item['rpl']) : '' }}</td>
                                    <td class="text-center @if($item['nilai_max'] == $item['animasi'] && $item['is_done'] == 1) bg-success text-white @endif">{{ $item['is_done'] == 1 ? strtoupper($item['animasi']) : '' }}</td>
                                    <td class="text-center">{{ $item['is_done'] == 1 ? strtoupper($item['jurusan']) : '' }}</td>
                                @else
                                    <td colspan="4" class="bg-danger text-white">Belum Melakukan Tes</td>
                                @endif
                            </tr>
                            @php $no++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection