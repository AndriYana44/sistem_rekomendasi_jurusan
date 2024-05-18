@extends('admin.layouts.app');

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

                <div class="card info-card customers-card">

                    <div class="card-body">
                        <h5 class="card-title">Total Siswa</h5>
    
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $siswa_counter }}</h6>
                            </div>
                        </div>
    
                    </div>

                </div>

            </div><!-- End Customers Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">

                <div class="card-body">
                    <h5 class="card-title">Siswa <span>| Sudah Melakukan Tes</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $siswa_answered }}</h6>
                            <span class="text-success small pt-1 fw-bold">{{ round(($siswa_answered / $siswa_counter) * 100, 2) }}%</span>

                        </div>
                    </div>
                </div>

                </div>
            </div><!-- End Revenue Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">

                    <div class="card-body">
                        <h5 class="card-title">Siswa <span>| Belum Melakukan Tes</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $siswa_counter - $siswa_answered }}</h6>
                                <span class="text-success small pt-1 fw-bold">{{ round((($siswa_counter - $siswa_answered) / $siswa_counter) * 100, 2) }}%</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Sales Card -->

            <!-- Reports -->
            </div>
        </div><!-- End Left side columns -->
    </div>
</section>
@endsection