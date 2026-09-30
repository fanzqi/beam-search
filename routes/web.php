<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;

Route::get(
    '/',
    [TranslationController::class, 'index']
)->name('translation.index');

Route::post(
    '/translate',
    [TranslationController::class, 'translate']
)->name('translation.translate');
