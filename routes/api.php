<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/contracts/{contract}/invoices', [\App\Http\Controllers\InvoiceController::class, 'store']);
    Route::get('/contracts/{id}/invoices', [\App\Http\Controllers\InvoiceController::class, 'listInvoices']);
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'getInvoice']);
    Route::post('/invoices/{invoice}/payment', [\App\Http\Controllers\InvoiceController::class, 'recordPayment']);
    Route::get('/contracts/{contract}/summary', [\App\Http\Controllers\InvoiceController::class, 'summary']);


});