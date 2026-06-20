<?php

use App\Http\Controllers\Api\Log\LogIngestController;
use Illuminate\Support\Facades\Route;

Route::post('/logs/{path}', [LogIngestController::class, 'store'])->name('api.logs.store');
