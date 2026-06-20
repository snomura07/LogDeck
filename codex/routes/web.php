<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\System\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('systems')->name('systems.')->group(function (): void {
    Route::get('/', [SystemController::class, 'index'])->name('index');
    Route::get('/create', [SystemController::class, 'create'])->name('create');
    Route::post('/', [SystemController::class, 'store'])->name('store');
});
