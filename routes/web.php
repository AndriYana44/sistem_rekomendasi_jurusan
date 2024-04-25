<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KejuruanController;
use App\Http\Controllers\NilaiKriteriaController;
use App\Http\Controllers\NilaiUNController;
use App\Http\Controllers\User\QuestionController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\UserController;
use App\Models\NilaiKriteria;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('login', [AuthController::class,'index'])->name('login');
Route::get('register', [AuthController::class,'register'])->name('register');
Route::post('proses_login', [AuthController::class,'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class,'logout'])->name('logout');

Route::post('proses_register',[AuthController::class,'proses_register'])->name('proses_register');

// kita atur juga untuk middleware menggunakan group pada routing
// didalamnya terdapat group untuk mengecek kondisi login
// jika user yang login merupakan admin maka akan diarahkan ke AdminController
// jika user yang login merupakan user biasa maka akan diarahkan ke UserController
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:admin']], function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index']);
            Route::prefix('data-siswa')->group(function () {
                Route::get('/', [DataSiswaController::class, 'index'])->name('data-siswa');
                Route::post('/store', [DataSiswaController::class, 'store'])->name('data-siswa-store');
                Route::delete('/destroy/{id}', [DataSiswaController::class, 'destroy'])->name('data-siswa-destroy');
            });

            Route::prefix('data-kejuruan')->group(function() {
                Route::get('/', [KejuruanController::class, 'index'])->name('data-kejuruan');
                Route::post('/store', [KejuruanController::class, 'store'])->name('kejuruan-store');
                Route::post('/update/{id}', [KejuruanController::class, 'update'])->name('kejuruan-update');
                Route::delete('/delete/{id}', [KejuruanController::class, 'delete'])->name('kejuruan-delete');
            });

            Route::get('data-soal-kejuruan', [SoalController::class, 'kejuruan'])->name('data-soal-kejuruan');
            Route::get('data-soal-psikotes', [SoalController::class, 'psikotes'])->name('data-soal-psikotes');
            Route::post('data-soal-update/{id}', [SoalController::class, 'update'])->name('soal-update');
            Route::delete('delete-soal/{id}', [SoalController::class, 'destroy'])->name('delete-soal');
            Route::post('data-soal-store', [SoalController::class, 'store'])->name('soal-store');

            Route::prefix('data-nilai-kriteria')->group(function() {
                Route::get('/', [NilaiKriteriaController::class, 'index'])->name('nilai-kriteria');
                Route::post('/store', [NilaiKriteriaController::class, 'store'])->name('nilai-kriteria-store');
                Route::put('/update/{id}', [NilaiKriteriaController::class, 'update'])->name('nilai-kriteria-update');
                Route::delete('/delete/{id}', [NilaiKriteriaController::class, 'delete'])->name('nilai-kriteria-delete');
            });

            Route::prefix('data-nilai-un')->group(function() {
                Route::get('/', [NilaiUNController::class, 'index'])->name('nilai-un');
                Route::post('/store', [NilaiUNController::class, 'store'])->name('nilai-un-store');
                Route::put('/update/{id}', [NilaiUNController::class, 'update'])->name('nilai-un-update');
                Route::delete('/delete/{id}', [NilaiUNController::class, 'delete'])->name('nilai-un-delete');
            });

            Route::prefix('data-users')->group(function() {
                Route::get('/', [UserController::class, 'index'])->name('users');
                Route::post('/store', [UserController::class, 'store'])->name('users-store');
                Route::put('/update/{id}', [UserController::class, 'update'])->name('users-update');
                Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users-delete');
            });

            Route::prefix('hasil-tes')->group(function() {
                Route::get('/kejuruan', [QuestionController::class, 'hasilTesKejuruan'])->name('hasil-tes-kejuruan');
                Route::get('/psikotes', [QuestionController::class, 'hasilTesPsikotes'])->name('hasil-tes-psikotes');
            });
        });
    });
    Route::group(['middleware' => ['cek_login:user']], function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('userDashboard');
        Route::prefix('question')->group(function () {
            Route::get('/rule', [QuestionController::class,'index'])->name('rule');
            Route::get('/psikotes', [QuestionController::class,'psikotes'])->name('psikotes');
            Route::get('/kejuruan', [QuestionController::class,'kejuruan'])->name('kejuruan');
            Route::post('/set-temp-start-questions', [QuestionController::class, 'setTempStartQuestions'])->name('setTempStartQuestions');
            Route::post('hasil-test', [QuestionController::class, 'hasilTes'])->name('hasil-tes');
        });

        Route::post('start-test', [QuestionController::class, 'startTest'])->name('start-test');
    });
});
