<?php

use App\Http\Controllers\adminController;
use App\Http\Middleware\isLogin;
use App\Http\Middleware\sudahLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\fetchApi;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\noticeController;
use App\Http\Middleware\RoleMiddleware;

route::get('login', [LoginController::class, 'login'])->middleware(sudahLogin::class)->name('login');
Route::get('/', [noticeController::class, 'index'])->middleware(isLogin::class);
Route::get('register', [LoginController::class, 'register']);
Route::post('postregister', [LoginController::class, 'postRegister']);
route::get('logout', [LoginController::class, 'logout']);
route::post('postlogin', [LoginController::class, 'postLogin']);
Route::get('rekap', [RekapController::class, 'index'])->middleware(isLogin::class);
Route::get('profile', [noticeController::class, 'profile'])->middleware(isLogin::class);
Route::post('profile/edit', [noticeController::class, 'profileEdit'])->name('profileEdit');
Route::post('profile/change-password', [noticeController::class, 'changePassword']);



Route::post('storeData', [noticeController::class, 'storeData'])->name('storeData');
Route::get('export_excel', [noticeController::class, 'export_excel'])->name('export_excel')->middleware(isLogin::class);
Route::post('updateData/', [noticeController::class, 'updateData'])->name('updateData');
Route::get('delete/{id}/{tanggal}', [noticeController::class, 'deleteData'])->name('deleteData');
Route::get('export_rekap', [RekapController::class, 'export_rekap'])->name('export_rekap');
Route::get('api/plat', [fetchApi::class, 'index']);
// group route untuk admin ketika kolom role true maka itu admin
Route::middleware('auth', RoleMiddleware::class)->group(function () {
    Route::get('admin', [adminController::class, 'index'])->name('admin');
    Route::get('admin/rekap', [adminController::class, 'rekap'])->name('rekap');
    Route::get('admin/kasir/{id}', [adminController::class, 'kasir'])->name('kasir');
    Route::get('admin/akun', [adminController::class, 'akun'])->name('akun');
    Route::get('admin/excel', [adminController::class, 'admin_excel'])->name('admin_excel');
    Route::get('admin/rekap/excel', [adminController::class, 'rekap_excel'])->name('rekap_excel');
    Route::post('admin/akun/tambah', [adminController::class, 'tambahAkun'])->name('tambahAkun');
    Route::post('admin/akun/ganti-password/{id}', [adminController::class, 'gantiPassword'])->name('gantiPassword');
    Route::post('admin/akun/edit', [adminController::class, 'editAkun'])->name('editAkun');
    Route::get('admin/akun/hapus/{id}', [adminController::class, 'hapusAkun'])->name('hapusAkun');
    Route::get('admin/profile', [adminController::class, 'profile'])->name('profile');
    Route::post('admin/profile/change-password', [adminController::class, 'changePassword'])->name('changePassword');
});
