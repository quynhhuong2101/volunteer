<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebApp\WebAppController;

Route::middleware(['web', 'auth'])->prefix('webapp')->name('webapp.')->group(function () {
    Route::get('/', [WebAppController::class, 'index'])->name('index');
    // Thêm các route khác của Web App tại đây
});
