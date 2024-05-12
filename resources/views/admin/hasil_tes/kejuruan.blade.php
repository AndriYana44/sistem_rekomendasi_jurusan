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
                                <form class="d-inline" action="{{ route('delete-hasil-tes-kejuruan', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-warning btn-sm deletehasiltes">Reset <i class="fa fa-refresh"></i></button>
                                </form>
                                <a href="#" class="btn btn-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#datasiswa').DataTable();
            $('.deletehasiltes').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Hasil tes kejuruan siswa akan direset!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().submit();
                    }else{
                        return false;
                    }
                })
            });
        });
    </script>
@endsection