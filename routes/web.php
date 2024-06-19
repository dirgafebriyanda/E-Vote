<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\CandidateController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ElectionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\VoteController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect('/menu-utama');
})->middleware('auth');

Route::middleware(['guest'])->group(function () {
    // Route Login
    Route::get('/masuk', [LoginController::class, 'index'])->name('login');
    Route::post('/masuk', [LoginController::class, 'authenticate'])->name('authenticate');

    // Route Register
    Route::get('/daftar', [RegisterController::class, 'index'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'store'])->name('store');
});

Route::middleware(['auth'])->group(function () {
    // Route Logout
    Route::post('/keluar', [LogoutController::class, 'index'])->name('logout');
    
    // Route Dashboard
    Route::get('/menu-utama', [DashboardController::class, 'index'])->name('dashboard');

    // Route User
    Route::get('/menu-utama/pengguna', [UserController::class, 'index'])->name('user')->middleware('role:Super admin');
    Route::get('/menu-utama/pengguna/lihat/{id}', [UserController::class, 'show'])->name('show')->middleware('role:Super admin');
    Route::post('/menu-utama/pengguna/perbarui/{id}', [UserController::class, 'update'])->name('update')->middleware('role:Super admin');
    Route::post('/menu-utama/pengguna/hapus/{id}', [UserController::class, 'destroy'])->name('delete')->middleware('role:Super admin');
    Route::post('/menu-utama/pengguna/role/{id}', [UserController::class, 'role'])->name('role')->middleware('role:Super admin');

    // Route Profile
    Route::get('/menu-utama/profil/{username}', [ProfileController::class, 'index'])->name('profile');
    Route::post('/menu-utama/profil/{username}', [ProfileController::class, 'update'])->name('update');
    Route::post('/menu-utama/hapus/akun/{username}', [ProfileController::class, 'delete'])->name('hapus.akun');

    // Route Candidate
    Route::resource('/menu-utama/pemilih', ElectionController::class)->names('election')->middleware('role:Super admin,Admin');
    Route::resource('/menu-utama/kandidat', CandidateController::class)->names('candidate')->middleware('role:Super admin,Admin');

    // Route Vote
    Route::get('/menu-utama/vote/{username}', [VoteController::class, 'index'])->name('vote.index');
    Route::post('/menu-utama/votes', [VoteController::class, 'vote'])->name('vote');
    Route::post('/cancel-vote', [VoteController::class, 'cancelVote'])->name('cancel.vote');

});
