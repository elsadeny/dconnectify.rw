<?php

use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketplaceController::class, 'index'])->name('home');
Route::get('/listings/{listing:slug}', [MarketplaceController::class, 'show'])->name('listings.show');
