@extends('admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Data Kejuruan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Kejuruan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addKejuruan">+ Tambah Kejuruan</button>
    <table id="kejuruan_table" class="table table-bordered">
        <thead>
             <tr>
                <th>No.</th>
                <th>Kejuruan</th>
                <th>Aksi</th>
             </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)  
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->kejuruan }}</td>
                <td>
                    <form class="d-inline" action="{{ route('kejuruan-delete', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>  
                    </form>
                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKejuruan{{ $item->id }}">Edit</a>    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="addKejuruan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('kejuruan-store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Form Tambah Kejuruan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jurusan" class="form-label">Kejuruan</label>
                            <input type="text" name="jurusan" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach ($data as $item) 
    <div class="modal fade" id="editKejuruan{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('kejuruan-update', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Form Tambah Kejuruan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jurusan" class="form-label">Kejuruan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ $item->kejuruan }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            @if(session('success'))
                swal("Sukses!", "{{ session('message') }}", "success");
            @endif

            $('#kejuruan_table').DataTable();
        });
    </script>
@endsection