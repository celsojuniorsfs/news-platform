<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Category\Interfaces\Http\Controllers\CategoryController;
use Src\News\Interfaces\Http\Controllers\NewsController;

Route::get('/', fn () => redirect()->route('news.index'));

Route::prefix('categories')->group(function (): void {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
});

Route::prefix('news')->group(function (): void {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::post('/', [NewsController::class, 'store'])->name('news.store');
    Route::get('/{news}', [NewsController::class, 'show'])->name('news.show');
});
