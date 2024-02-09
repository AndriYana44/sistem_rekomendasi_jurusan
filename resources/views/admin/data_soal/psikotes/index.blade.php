@extends('admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Data Soal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <hr>

    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addSiswa">+ Soal Psikotes</button>
    <div class="card">
        <div class="card-body py-3">
            <table class="table table-bordered table-stripped" id="datasiswa">
                <thead>
                    <tr>
                        <th style="width: 15%;">Tipe Soal</th>
                        <th style="width: 60%;">Pertanyaan</th>
                        <th style="width: 20%;">Kategori Soal</th>
                        <th style="width: 15%;">Level Soal</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->tipe_soal }}</td>
                            <td>{!! $item->pertanyaan !!}</td>
                            <td>{{ $item->kategori_soal }}</td>
                            <td>{{ $item->level_soal }}</td>
                            <td>
                                <form class="d-inline" action="{{ route('delete-soal', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" id="delete_soal">Delete</button>
                                </form>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSiswa{{ $item->id }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('soal-store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form tambah siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="text" name="kategori" value="psikotes" hidden>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tipe">Tipe Soal</label>
                                    <select class="select2" name="tipe" id="tipe">
                                        <option value=""></option>
                                        <option value="verbal">Verbal</option>
                                        <option value="numerik">Numerik</option>
                                        <option value="logika">Logika</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="level">Level Soal</label>
                                    <select class="select2" name="level" id="level">
                                        <option value=""></option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan</label>
                                    <textarea name="pertanyaan" class="pertanyaan" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <span class="mt-3"><strong>pilihan ganda</strong></span>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="pg">A</label>
                                    <input type="text" name="pg[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="pg">B</label>
                                    <input type="text" name="pg[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="pg">C</label>
                                    <input type="text" name="pg[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="pg">D</label>
                                    <input type="text" name="pg[]" class="form-control">
                                </div>
                            </div>

                            <span class="mt-3"><strong>Kunci Jawaban</strong></span>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="jawaban">Jawaban</label>
                                    <select class="select2" name="jawaban" id="jawaban">
                                        <option value=""></option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                        <option value="d">D</option>
                                    </select>
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

    <!-- Modal Edit -->
    @foreach ($data as $item) 
    {{-- @dd($item)   --}}
    <div class="modal fade" id="editSiswa{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('soal-update', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form edit soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="text" name="kategori" value="psikotes" hidden>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tipe">Tipe Soal</label>
                                    <select class="select2" name="tipe" id="tipe">
                                        <option value=""></option>
                                        <option value="verbal" {{ $item->tipe_soal == 'verbal' ? 'selected="selected"' : '' }}>Verbal</option>
                                        <option value="numerik" {{ $item->tipe_soal == 'numerik' ? 'selected="selected"' : '' }}>Numerik</option>
                                        <option value="logika" {{ $item->tipe_soal == 'logika' ? 'selected="selected"' : '' }}>Logika</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="level">Level Soal</label>
                                    <select class="select2" name="level" id="level">
                                        <option value=""></option>
                                        <option value="low" {{ $item->level_soal == 'low' ? 'selected="selected"' : '' }}>Low</option>
                                        <option value="medium" {{ $item->level_soal == 'medium' ? 'selected="selected"' : '' }}>Medium</option>
                                        <option value="high" {{ $item->level_soal == 'high' ? 'selected="selected"' : '' }}>High</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan</label>
                                    <textarea name="pertanyaan" cols="30" rows="10" class="pertanyaan">{{ $item->pertanyaan }}</textarea>
                                </div>
                            </div>

                            <span class="mt-3"><strong>pilihan ganda</strong></span>
                            @foreach ($item->opsiJawaban as $k => $pg)
                            @php
                                if ($k == 0) { $label = 'A'; }
                                elseif ($k == 1) { $label = 'B'; }
                                elseif ($k == 2) { $label = 'C'; }
                                else { $label = 'D'; }
                            @endphp

                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="pg">{{ $label }}</label>
                                    <input type="text" name="pg[]" value="{{ $pg->opsi_jawaban }}" class="form-control">
                                </div>
                            </div>
                            @endforeach

                            @foreach ($item->opsiJawaban as $k => $jawaban)
                                <input type="text" name="id_jawaban[]" value="{{ $jawaban->id }}" hidden>
                            @endforeach
                            <span class="mt-3"><strong>Kunci Jawaban</strong></span>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="jawaban">Jawaban</label>
                                    <select class="select2" name="jawaban" id="jawaban">
                                        <option value=""></option>
                                        @foreach ($item->opsiJawaban as $k => $jawaban)
                                        @php
                                            if ($k == 0) { $label = 'A'; }
                                            elseif ($k == 1) { $label = 'B'; }
                                            elseif ($k == 2) { $label = 'C'; }
                                            else { $label = 'D'; }   
                                        @endphp
                                            <option value="{{ strtolower($label) }}" {{ $jawaban->is_jawaban == 1 ? 'selected="selected"' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
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
    @endforeach

    @section('script')
        <script>

            $(document).ready( function () {
                ClassicEditor
                    .create( document.querySelector('.pertanyaan') )
                    .then( editor => {
                            console.log( editor );
                    } )
                    .catch( error => {
                            console.error( error );
                    } );
                // declare select2
                $('.select2').select2({
                    placeholder: 'Pilih salah satu',
                    width: '100%',
                    dropdownParent: $('#addSiswa')
                });
                // declare datatable
                $('#datasiswa').DataTable({
                    scrollX: true,
                });

                // delete siswa action
                $('#delete_soal').on('click', function(e) {
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