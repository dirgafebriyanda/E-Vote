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
use App\Http\Controllers\Dashboard\VoterController;
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
    return redirect('/dashboard');
})->middleware('auth');

Route::middleware(['guest'])->group(function () {
    // Route Index
    // Route::get('/', function () {
    //     return view('index');
    // });

    // Route Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

    // Route Register
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('store');
});

Route::middleware(['auth'])->group(function () {
    // Route Logout
    Route::post('/logout', [LogoutController::class, 'index'])->name('logout');

    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route User
    Route::get('/dashboard/user', [UserController::class, 'index'])
        ->name('user')
        ->middleware('role:Super admin');
    Route::get('/dashboard/user/show/{id}', [UserController::class, 'show'])
        ->name('show')
        ->middleware('role:Super admin');
    Route::post('/dashboard/user/update/{id}', [UserController::class, 'update'])
        ->name('update')
        ->middleware('role:Super admin');
    Route::post('/dashboard/user/delete/{id}', [UserController::class, 'destroy'])
        ->name('delete')
        ->middleware('role:Super admin');
    Route::post('/dashboard/user/role/{id}', [UserController::class, 'role'])
        ->name('role')
        ->middleware('role:Super admin');

    // Route Profile
    Route::get('/dashboard/profile/{username}', [ProfileController::class, 'index'])->name('profile');
    Route::post('/dashboard/profile/{username}', [ProfileController::class, 'update'])->name('update');
    Route::post('/dashboard/delete/acount/{username}', [ProfileController::class, 'delete'])->name('hapus.akun');

    // Route Voter
    Route::resource('/dashboard/voters', VoterController::class)
        ->names('voter')
        ->middleware('role:Super admin,Admin');

    // Route Candidate
    Route::resource('/dashboard/candidates', CandidateController::class)
        ->names('candidate')
        ->middleware('role:Super admin,Admin');
    
    // Route Election
        Route::resource('/dashboard/elections', ElectionController::class)
            ->names('election')
            ->middleware('role:Super admin,Admin');

    // Route Vote
    Route::get('/dashboard/votes/{election}', [VoteController::class, 'index'])->name('vote.index');
    Route::post('/dashboard/vote', [VoteController::class, 'vote'])->name('vote.store');
    Route::post('/dashboard/cancel-vote', [VoteController::class, 'cancelVote'])->name('cancel.vote');
    
    // Route::get('/dashboard/vote2/{election}', [VoteController::class, 'test'])->name('vote2');
    // Route::post('/dashboard/testVote', [VoteController::class, 'testVote'])->name('testVote');
});
