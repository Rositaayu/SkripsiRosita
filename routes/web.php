<?php

use App\Models\Berita;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WartawanController;
use App\Http\Controllers\SuperEditorController;
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

// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $jumlahPublish = Berita::where('status_berita', 3)->count();
    $jumlahProgress = Berita::where('status_berita', 2)->count();
    $jumlahPending = Berita::where('status_berita', 1)->count();
    $jumlahReview = Berita::where('status_berita', 0)->count();

    return view('pages.index', compact('jumlahPublish', 'jumlahProgress', 'jumlahPending', 'jumlahReview'));
})->name('home')->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Account
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password')->middleware('auth');
Route::put('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth');

// Super Editor
Route::get('/super-editor', [SuperEditorController::class, 'index'])->name('super-editor')->middleware(['admin']);
Route::get('/super-editor/create', [SuperEditorController::class, 'create'])->name('super-editor.create')->middleware(['admin']);
Route::post('/super-editor', [SuperEditorController::class, 'store'])->name('super-editor.store')->middleware(['admin']);
Route::get('/super-editor/{id}/edit', [SuperEditorController::class, 'edit'])->name('super-editor.edit')->middleware(['admin']);
Route::put('/super-editor/{id}', [SuperEditorController::class, 'update'])->name('super-editor.update')->middleware(['admin']);
// Route::get('/super-editor/destroy', [SuperEditorController::class, 'destroy'])->name('super-editor.destroy')->middleware(['admin']);

//Editor
Route::get('/editor', [EditorController::class, 'index'])->name('editor')->middleware(['admin']);
Route::get('/editor/create', [EditorController::class, 'create'])->name('editor.create')->middleware(['admin']);
Route::post('/editor', [EditorController::class, 'store'])->name('editor.store')->middleware(['admin']);
Route::get('/editor/{id}/edit', [EditorController::class, 'edit'])->name('editor.edit')->middleware(['admin']);
Route::put('/editor/{id}', [EditorController::class, 'update'])->name('editor.update')->middleware(['admin']);

// Wartawan
Route::get('/wartawan', [WartawanController::class, 'index'])->name('wartawan')->middleware(['admin']);
Route::get('/wartawan/create', [WartawanController::class, 'create'])->name('wartawan.create')->middleware(['admin']);
Route::post('/wartawan', [WartawanController::class, 'store'])->name('wartawan.store')->middleware(['admin']);
Route::get('/wartawan/{id}/edit', [WartawanController::class, 'edit'])->name('wartawan.edit')->middleware(['admin']);
Route::put('/wartawan/{id}', [WartawanController::class, 'update'])->name('wartawan.update')->middleware(['admin']);

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita')->middleware('auth');
Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create')->middleware('auth');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show')->middleware('auth');
Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store')->middleware('auth');
Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit')->middleware('auth');
Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update')->middleware('auth');
Route::get('/berita/{id}/comment', [BeritaController::class, 'comment'])->name('berita.comment')->middleware('auth');
Route::post('/berita/{id}/comment', [BeritaController::class, 'storeComment'])->name('berita.storeComment')->middleware('auth');
