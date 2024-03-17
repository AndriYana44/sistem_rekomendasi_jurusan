@extends('user.layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Soal Kejuruan</h1>
    <div class="waktu d-flex" style="position: relative; min-height: 30px;margin-bottom: 10px;">
        <span>Soal kejuruan dengan jumlah <strong>{{ $soal_count }} soal.</strong></span>
        <div class="d-flex" style="position: absolute; right: 0;">
            <button type="button" class="btn btn-primary">
                Sisa waktu: <span class="badge badge-light"><div class="countdown" id="countdown"></div></span>
            </button>
        </div>
    </div>
    <div class="alert alert-primary" role="alert">
        <span>Kerjakan dengan jujur dan teliti</span>
    </div>
    <form action="{{ route('hasil-tes') }}" method="post">
        @csrf
        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    @foreach ($soal as $key => $item)
                    <div class="col-sm-6">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="soal d-flex mt-3">
                                    {{ $key+1 }}. &nbsp; {!! $item->pertanyaan !!}
                                </div>
                                <input type="text" name="jenis_tes" value="kejuruan" hidden>
                                <input type="text" name="id_soal[]" value="{{ $item->id }}" hidden>
                                <div class="jawaban-wrapper">
                                    @foreach ($item->opsiJawaban as $j)  
                                    <div class="form-check ml-3">
                                        <input type="radio" id="{{ $j->id }}" class="form-check-input" name="{{ $item->id }}[]" value="{{ $j->id }}">
                                        <label class="form-check-label" for="{{ $j->id }}">{{ $j->opsi_jawaban }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menentukan waktu akhir countdown (8 menit dari waktu saat ini)
            const countdownTime = new Date().getTime() + 8 * 60 * 1000; // 8 menit dalam milidetik

            // Update hitungan mundur setiap 1 detik
            const countdownTimer = setInterval(function () {
                const now = new Date().getTime();
                const distance = countdownTime - now;

                // Perhitungan waktu
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Tampilkan hasil pada elemen dengan id "countdown"
                document.getElementById('countdown').innerHTML = `
                    ${minutes < 10 ? '0' : ''}${minutes} menit
                    ${seconds < 10 ? '0' : ''}${seconds} detik
                `;

                // Hentikan countdown jika waktu telah habis
                if (distance < 0) {
                    clearInterval(countdownTimer);
                    swal.fire({
                        title: "Waktu anda habis!",
                        text: "jawaban anda akan diserahkan.",
                        confirmButtonText: "Oke",
                        showCancelButton: false,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('userDashboard') }}";
                        }
                    });
                }
            }, 1000);
        });

        !function(){
            "use strict";
            window.addEventListener("contextmenu",(e => {
                e.preventDefault()
            })),
            window.addEventListener("keydown",(e => {
                e.ctrlKey&&e.preventDefault(),
                e.altKey&&e.preventDefault(),
                e.metaKey&&e.preventDefault(),
                e.shiftKey&&e.preventDefault(),
                e.repeat&&e.preventDefault()})),
                window.addEventListener("dblclick",(() => {
                    document.querySelector("body").setAttribute("style","user-select: none;")
                })),
                window.addEventListener("click",(()=>{
                    document.querySelector("body").setAttribute("style","user-select: none;")
                }))
            }();
    </script>
@endsection