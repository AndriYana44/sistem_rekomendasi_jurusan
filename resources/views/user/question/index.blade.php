@extends('user.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card wow fadeIn">
        <div class="card-body py-5 px-4">
            @if ($soal_access)
                <h1>Ketentuan Tes Psikometrik</h1>
                <!-- Tambahkan ketentuan di sini -->
                <p>1. Anda memiliki waktu tertentu untuk menyelesaikan setiap bagian tes. Pastikan untuk mengelola waktu dengan baik.</p>
                <p>2. Pilih jawaban yang paling sesuai menurut Anda. Pastikan untuk menandai jawaban Anda dengan benar.</p>
                <!-- ... -->
            @else
                <h3>Anda Sudah Mengerjakan Soal.</h3>
            @endif
        </div>
        <div class="card-footer">
            @if ($soal_access)
                <button class="btn btn-primary start">Mulai Tes</button>
            @else
                <a href="{{ route('userDashboard') }}" class="btn btn-primary">Lihat Hasil Tes</a>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $('.start').click(function() {
            var url = "{{ route('psikotes') }}";
            var user_id = "{{ auth()->user()->id }}";
            console.log(user_id);
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
    </script>
@endsection