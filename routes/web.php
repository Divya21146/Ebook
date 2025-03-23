<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [PdfController::class, 'index'])->name('pdf.index');
Route::get('/pdf/{pdf}', [PdfController::class, 'show'])->name('pdf.show');
Route::post('/payment', [PdfController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/success', [PdfController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failure', [PdfController::class, 'paymentFailure'])->name('payment.failure');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pdfs/upload', [PdfController::class, 'pdfcreate'])->name('pdfs.create');
    Route::post('/pdfs/store', [PdfController::class, 'store'])->name('pdfs.store');
    Route::get('/pdfs/{pdf}/edit', [PdfController::class, 'edit'])->name('pdfs.edit'); // Edit form
    Route::put('/pdfs/{pdf}', [PdfController::class, 'update'])->name('pdfs.update');   // Update action
    Route::delete('/pdfs/{pdf}', [PdfController::class, 'destroy'])->name('pdfs.destroy'); // Delete action
});


