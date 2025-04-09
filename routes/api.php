<?php

use App\Http\Controllers\BookTicketController;
use App\Http\Controllers\DichVuAnUongController;
use App\Http\Controllers\GheController;
use App\Http\Controllers\LoaiVeController;
use App\Http\Controllers\MoMoPaymentController;
use App\Http\Controllers\PhimController;
use App\Http\Controllers\PhongChieuController;
use App\Http\Controllers\RapPhimController;
use App\Http\Controllers\SuatChieuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * @OA\PathItem(path="/api")
 */


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('')->group(function () {
    Route::resource('phim', PhimController::class);
    Route::get('suatchieu/phim/{ma_phim}', [SuatChieuController::class, 'getByPhim'])->name('suatchieu.getByPhim');
    Route::get('phong/dsghe/{ma_phong}', [PhongChieuController::class, 'getGhebyPhong'])->name('phongchieuc.getByGhe');

    Route::resource('loaive', LoaiVeController::class);
    Route::resource('ghe', GheController::class);
    Route::resource('rap', RapPhimController::class);
    Route::resource('phong', PhongChieuController::class);
    Route::resource('dichvuanuong', DichVuAnUongController::class);

    Route::resource('ve', BookTicketController::class);
    Route::post('create-payment', [MoMoPaymentController::class, 'createPayment']);
    Route::post('callback', [MoMoPaymentController::class, 'callback']);
    Route::post('checkTrasaction', [MoMoPaymentController::class, 'ipn']);
});
