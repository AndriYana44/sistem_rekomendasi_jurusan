@extends('admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Nilai Ujian Nasional (UN)</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Nilai-UN</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>

    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addun">+ Tambah Nilai UN</button>
    <table class="table table-bordered" id="table-nilai-un">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->siswa->nama }}</td>
                    <td>{{ $item->mapel }}</td>
                    <td>{{ $item->nilai }}</td>
                    <td>
                        <form id="form-delete-un-{{ $item->id }}" class="d-inline" action="{{ route('nilai-un-delete', $item->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="button" onclick="deleteData({{ $item->id }})" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editun{{ $item->id }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="addun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nilai UN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nilai-un-store') }}" method="POST">
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

    <!-- Modal Edit -->
    @foreach ($data as $item)  
    <div class="modal fade" id="editun{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nilai UN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nilai-un-update', $item->id) }}" method="POST">
                    @csrf
                    @method('put')
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
        function deleteData(id) {
            swal({
                title: "Anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(`#form-delete-un-${id}`).submit();
                }
            });
        }

        $(document).ready(function () {
            $('#table-nilai-un').DataTable();

            @if(session('success'))
                swal(
                    "{{ session('success') == true ? 'Sukses!' : 'Gagal!' }}", 
                    "{{ session('message') }}", 
                    "{{ session('success') == true ? 'success' : 'error' }}"
                );
            @endif
        });
    </script>
@endsection