@extends('admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Data Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>

    <button class="mb-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">+ Tambah User</button>
    <table class="table table-bordered" id="table-users">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email != null ? $item->email : '-' }}</td>
                    <td>{{ $item->level }}</td>
                    <td>
                        <form action="{{ route('users-delete', $item->id) }}" class="d-inline" method="POST">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editUser" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-warning" role="alert">
                    Untuk menambahkan user dengan role user/siswa bisa ditambahkan di menu 
                    <a href="{{ route('data-siswa') }}">siswa</a>
                  </div>
                <form action="{{ route('users-store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="level" class="form-label">Nilai</label>
                            <input type="text" value="admin" class="form-control" disabled>
                            <input type="text" value="admin" name="level" hidden>
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
    <div class="modal fade" id="editUser{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nilai UN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users-update', $item->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="siswa" class="form-label">Siswa</label>
                            <input type="text" name="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="level" class="form-label">Nilai</label>
                            <input type="text" value="admin" class="form-control" disabled>
                            <input type="text" value="admin" name="level" hidden>
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
            $('#table-users').DataTable();
        });
    </script>
@endsection