<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperEditorController;
use App\Http\Controllers\EditorController;
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
    return view('pages.index');
})->name('home')->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Super Editor
Route::get('/super-editor', [SuperEditorController::class, 'index'])->name('super-editor')->middleware('auth');
Route::get('/super-editor/create', [SuperEditorController::class, 'create'])->name('super-editor.create')->middleware('auth');
Route::post('/super-editor', [SuperEditorController::class, 'store'])->name('super-editor.store')->middleware('auth');
Route::get('/super-editor/{id}/edit', [SuperEditorController::class, 'edit'])->name('super-editor.edit')->middleware('auth');
Route::put('/super-editor/{id}', [SuperEditorController::class, 'update'])->name('super-editor.update')->middleware('auth');
// Route::get('/super-editor/destroy', [SuperEditorController::class, 'destroy'])->name('super-editor.destroy')->middleware('auth');

//Editor
Route::get('/editor', [EditorController::class, 'index'])->name('editor')->middleware('auth');
Route::get('/editor/create', [EditorController::class, 'create'])->name('editor.create')->middleware('auth');
Route::post('/editor', [EditorController::class, 'store'])->name('editor.store')->middleware('auth');
Route::get('/editor/{id}/edit', [EditorController::class, 'edit'])->name('editor.edit')->middleware('auth');
Route::put('/editor/{id}', [EditorController::class, 'update'])->name('editor.update')->middleware('auth');
