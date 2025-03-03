<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\SendMoneyController;
use App\Models\RecurringTransfer;
use Illuminate\Support\Facades\Route;

Route::post('/v1/login', LoginController::class)->middleware(['guest:sanctum', 'throttle:api.login']);

Route::middleware(['auth:sanctum', 'throttle:api'])->prefix('v1')->group(function () {
    Route::get('/account', AccountController::class);
    Route::post('/wallet/send-money', SendMoneyController::class);

    Route::get('/recurring-transfers', [RecurringTransfer::class, 'index'])->name('recurring-transfers.index');
    Route::post('/recurring-transfers', [RecurringTransfer::class, 'store'])->name('recurring-transfers.store');
    Route::delete('/recurring-transfers/{id}', [RecurringTransfer::class, 'destroy'])->name('recurring-transfers.destroy');
});
