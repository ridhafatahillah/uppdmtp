<?php

use App\Http\Middleware\isLogin;
use App\Http\Middleware\sudahLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\fetchApi;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\noticeController;

Route::get('/', [noticeController::class, 'index'])->middleware(isLogin::class);
Route::get('register', [LoginController::class, 'register']);
Route::post('postregister', [LoginController::class, 'postRegister']);
route::get('login', [LoginController::class, 'login'])->middleware(sudahLogin::class);
route::get('logout', [LoginController::class, 'logout']);
route::post('postlogin', [LoginController::class, 'postLogin']);
Route::get('rekap', [RekapController::class, 'index'])->middleware(isLogin::class);

Route::post('storeData', [noticeController::class, 'storeData'])->name('storeData');
Route::get('export_excel', [noticeController::class, 'export_excel'])->name('export_excel');
Route::post('updateData/', [noticeController::class, 'updateData'])->name('updateData');
Route::get('delete/{id}/{tanggal}', [noticeController::class, 'deleteData'])->name('deleteData');
Route::get('export_rekap', [RekapController::class, 'export_rekap'])->name('export_rekap');
Route::get('api/plat', [fetchApi::class, 'index']);
