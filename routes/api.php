<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('contracts')->group(function () {
        Route::get('/{contract}/summary', [\App\Http\Controllers\InvoiceController::class, 'summary']);
        Route::get('/{contract}/invoices', [\App\Http\Controllers\InvoiceController::class, 'listInvoices']);
        Route::post('/{contract}/invoices', [\App\Http\Controllers\InvoiceController::class, 'store']);
    });
    Route::prefix('invoices')->group(function () {
        Route::get('/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'getInvoice']);
        Route::post('/{invoice}/payment', [\App\Http\Controllers\InvoiceController::class, 'recordPayment']);
    });
      Route::prefix('tenant')->group(function () {
    Route::get('/{tenant}/report', [\App\Http\Controllers\TenantsController::class, 'download']);

    });

});