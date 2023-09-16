<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ContractorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::post('profileUpdate', [SettingsController::class, 'profileUpdate'])->name('profileUpdate'); 

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/settings', function () {
        return view('settings');
    });

    Route::post('scanUpload', [FileController::class, 'scanUpload'])->name('scanUpload'); 

    Route::post('pdfUpload', [FileController::class, 'pdfUpload'])->name('pdfUpload'); 
    
    Route::get('/admin', [AdminController::class, 'getUsers']);

    Route::get('/contractors', [ContractorController::class, 'getData']);

    Route::get('/deleteuser/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

    Route::get('/getScanText', [ScanController::class, 'getData']);

    Route::post('/send', [FileController::class, 'sendScan'])->name('sendScan'); 

    Route::get('/deletefile/{id}', [FileController::class, 'deleteFile'])->name('deleteFile');

    Route::post('/addScanner', [ScanController::class, 'addScanner'])->name('addScanner'); 
});

