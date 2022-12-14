<?php

use App\Http\Controllers\EducationTeacherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileStudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileTeacherController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SertificateController;
use App\Models\Teacher;

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


Route::get('/dashboard', function () {
    return view('dashboard.index', [
        'teachers' => Teacher::where('status', true)->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/status', [ProfileTeacherController::class, 'activateStatus'])->name('teacher.status');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/profile/student', ProfileStudentController::class)->only('update');
    Route::resource('/profile/teacher', ProfileTeacherController::class)->only('update');
    Route::resource('/profile/education', EducationTeacherController::class);
    Route::resource('/profile/certificate', SertificateController::class);
    Route::post('/search', [SearchController::class, 'filter'])->name('search');
});

require __DIR__ . '/auth.php';
