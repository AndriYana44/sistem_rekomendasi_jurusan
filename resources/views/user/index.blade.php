@extends('user.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="banner mt-3 d-flex mb-2">
                        <img src="{{ asset('assets/img/banner-1.jpeg') }}" alt="banner-1" width="50%">
                        <img src="{{ asset('assets/img/banner-2.jpeg') }}" alt="banner-2" width="50%">
                    </div>
                    <div class="d-flex justify-content-center flex-column">
                        <h2 class="text-center">Selamat Datang di Sistem Rekomendasi Jurusan</h2>
                        <h2 class="text-center">SMK AMALIAH CIAWI</h2>
                        <h3 class="text-center">Tahun ajaran 2023</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title" style="border-bottom: 1px solid #999;">Jumlah Siswa</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon d-flex align-items-center justify-content-center">
                                    <h3><i class="bi bi-people"></i></h3>
                                </div>
                                <div class="ps-3">
                                    <h3>10 Siswa</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title mb-2" style="border-bottom: 1px solid #999;">Sudah melakukan tes</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>4 Siswa</h4>
                                    <span class="text-success small pt-1 fw-bold">4%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title" style="border-bottom: 1px solid #999;">Belum melakukan tes</h5>
        
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>6 Siswa</h4>
                                    <span class="text-success small pt-1 fw-bold">6%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            @if($msg = Session::get('message'))
                console.log('oke');
                swal.fire({
                    text: "{{ $msg }}",
                    confirmButtonText: "Oke",
                    showCancelButton: true,
                });
            @endif
        });
    </script>
@endsection