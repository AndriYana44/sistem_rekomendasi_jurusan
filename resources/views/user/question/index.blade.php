@extends('user.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card wow fadeIn">
        @if(is_null($has_start_test_kejuruan) && is_null($has_start_test_psikotes))
        <div class="card-body py-5 px-4">
            <h1>Ketentuan Tes Psikometrik</h1>
            <!-- Tambahkan ketentuan di sini -->
            <p>1. Anda memiliki waktu tertentu untuk menyelesaikan setiap bagian tes. Pastikan untuk mengelola waktu dengan baik.</p>
            <p>2. Pilih jawaban yang paling sesuai menurut Anda. Pastikan untuk menandai jawaban Anda dengan benar.</p>
            <!-- ... -->
        </div>
        <div class="card-footer">
            <button class="btn btn-primary start">Mulai Tes</button>
        </div>
        @elseif(is_null($has_start_test_kejuruan) && !is_null($has_start_test_psikotes))
        <div class="card-body py-5 px-4">
            <h3>Anda sudah melakukan tes psikometrik dan belum melakukan tes kejuruan</h3>
            <h3>Sekarang anda akan diarahkan untuk melakukan tes kejuruan</h3>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary start-kejuruan">Mulai Tes Kejuruan</button>
        </div>
        @else
        <div class="card-body py-5 px-4">
            <h3>Anda sudah melakukan tes</h3>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary start">Lihat Hasil Tes</button>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
    <script>
        $('.start').click(function() {
            // ajax insert start test
            $.ajax({
                url: "{{ route('start-test') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    jenis_tes: "psikotes"
                }
            }).done(function(data) {
                var url = "{{ route('psikotes') }}";
                var user_id = "{{ auth()->user()->id }}";

                Swal.fire({
                    title: "Mulai sekarang?",
                    confirmButtonText: "Oke",
                    showCancelButton: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

        $('.start-kejuruan').click(function() {
            // ajax insert start test
            $.ajax({
                url: "{{ route('start-test') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    jenis_tes: "kejuruan"
                }
            }).done(function(data) {
                var url = "{{ route('kejuruan') }}";
                var user_id = "{{ auth()->user()->id }}";

                Swal.fire({
                    title: "Mulai sekarang?",
                    confirmButtonText: "Oke",
                    showCancelButton: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
@endsection