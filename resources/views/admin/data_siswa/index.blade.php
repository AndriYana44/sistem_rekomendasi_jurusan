@extends('admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Data Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>

    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addSiswa">+ Data Siswa</button>
    <div class="card">
        <div class="card-body py-3">
            <table class="table table-bordered table-stripped" id="datasiswa">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Asal Sekolah</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->asal_sekolah }}</td>
                            <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'  }}</td>
                            <td>{{ $item->agama }}</td>
                            <td>{{ $item->tempat_lahir }}</td>
                            <td>{{ $item->tgl_lahir }}</td>
                            <td>{{ $item->no_telp }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <form action="{{ route('data-siswa-destroy', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" id="deletesiswa">Delete</button>
                                </form>
                                <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="{{ route('data-siswa-store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form tambah siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input type="text" name="nisn" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="asal_sekolah">Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah" class="form-control">
                                </div>
                            </div>
            
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2">
                                        <option value=""></option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-control select2">
                                        <option value=""></option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="text" name="tgl_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="no_hp">No. HP</label>
                                    <input type="text" name="no_hp" class="form-control">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                            </div>
    
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('script')
        <script>

            $(document).ready( function () {
                // declare select2
                $('.select2').select2({
                    placeholder: 'Pilih salah satu',
                    width: '100%',
                    dropdownParent: $('#addSiswa')
                });
                // declare datatable
                $('#datasiswa').DataTable({
                    scrollX: true,
                    responsive: true,
                });

                // delete siswa action
                $('#deletesiswa').on('click', function(e) {
                    e.preventDefault();
                    console.log('oke');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Data siswa akan dihapus secara permanen!",
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
@endsection