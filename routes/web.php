<?php

use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\SavedListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketplaceController::class , 'index'])->name('home');
Route::get('/category/{type}', [MarketplaceController::class , 'category'])->name('category.show');
Route::get('/listings/{listing}', [MarketplaceController::class , 'show'])->name('listings.show');

Route::middleware('auth')->group(function () {
    Route::get('/saved', [SavedListingController::class , 'index'])->name('saved.index');
    Route::post('/listings/{listing}/save', [SavedListingController::class , 'store'])->name('saved.store');
    Route::delete('/listings/{listing}/save', [SavedListingController::class , 'destroy'])->name('saved.destroy');
});