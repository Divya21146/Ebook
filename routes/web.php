<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PdfController::class, 'index'])->name('pdf.index'); // List PDFs
Route::get('/pdf/{pdf}', [PdfController::class, 'show'])->name('pdf.show'); // Single PDF details
Route::post('/payment', [PdfController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/success', [PdfController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failure', [PdfController::class, 'paymentFailure'])->name('payment.failure');