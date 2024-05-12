@extends('admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Nilai Kriteria</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">nilai-kriteria</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>

    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addKriteria">+ Nilai Kriteria</button>
    <div class="card">
        <div class="card-body py-3">
            <table class="__datatable table table-bordered" id="kriteria-table">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Jurusan</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->siswa->nama }}</td>
                            <td>{{ $item->kejuruan->kejuruan }}</td>
                            <td>{{ $item->mapel }}</td>
                            <td>{{ $item->nilai }}</td>
                            <td>
                                <form class="d-inline" id="form-delete-kriteria-{{ $item->id }}" action="{{ route('nilai-kriteria-delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm deletekriteria" onclick="deleteData({{ $item->id }})" type="button">Delete</button>
                                </form>
                                <a class="btn btn-warning btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#editKriteria{{ $item->id }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addKriteria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nilai Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nilai-kriteria-store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="siswa" class="form-label">Siswa</label>
                            <select name="siswa" id="siswa" class="form-control">
                                <option value=""></option>
                                @foreach ($siswa as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-control">
                                <option value=""></option>
                                @foreach ($kejuruan as $jr)
                                    <option value="{{ $jr->id }}">{{ $jr->kejuruan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mapel" class="form-label">Mata pelajaran</label>
                            <input type="text" name="mapel" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="text" name="nilai" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit -->
    @foreach ($data as $item) 
    <div class="modal fade" id="editKriteria{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Nilai Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nilai-kriteria-update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="siswa" class="form-label">Siswa</label>
                            <select name="siswa" id="siswa" class="form-control">
                                <option value=""></option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}" {{ $item->siswa_id == $s->id ? 'selected="selected"' : '' }}>{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jurusan" class="form-label">Kejuruan</label>
                            <select name="jurusan" id="jurusan" class="form-control">
                                <option value=""></option>
                                @foreach ($kejuruan as $jr)
                                    <option value="{{ $jr->id }}" {{ $item->jurusan_id == $jr->id ? 'selected="selected"' : '' }}>{{ $jr->kejuruan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mapel" class="form-label">Mata pelajaran</label>
                            <input type="text" name="mapel" class="form-control" value="{{ $item->mapel }}">
                        </div>
                        <div class="form-group">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="text" name="nilai" class="form-control" value="{{ $item->nilai }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

@endsection

@section('script')
    <script>
        // delete kriteria action
        $('.deletekriteria').on('click', function(e) {
            e.preventDefault();
            console.log('oke');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Nilai kriteria akan dihapus secara permanen!",
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
        
        $(document).ready(function () {
            @if(session('success'))
                swal(
                    "{{ session('success') == true ? 'Sukses!' : 'Gagal!' }}", 
                    "{{ session('message') }}", 
                    "{{ session('success') == true ? 'success' : 'error' }}"
                );
            @endif

            $('#kriteria-table').DataTable();
        });
    </script>
@endsection