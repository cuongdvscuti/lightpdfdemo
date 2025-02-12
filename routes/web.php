<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LightPDFController;

Route::get('/upload', [LightPDFController::class, 'showForm'])->name('lightpdf.upload');
Route::post('/process-file', [LightPDFController::class, 'uploadAndProcess'])->name('lightpdf.process');
