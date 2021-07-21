<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/voeg-recept-toe', function () {
    return view('voeg-recept-toe');
})->name('voeg-recept-toe');
Route::middleware(['auth:sanctum', 'verified'])->get('/categories', function () {
    return view('categories');
})->name('categories');



Route::get('/download/recipe/{id}',[DownloadController::class, 'downloadPdf']);
Route::get('/download',[DownloadController::class,'index'])->name('download-recipes');
Route::get('/download/{id}',[DownloadController::class,'show']);