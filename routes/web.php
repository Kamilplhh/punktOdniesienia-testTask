<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ContractorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PHPMailerController;

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

    Route::post('addFile', [FileController::class, 'addFile'])->name('addFile'); 
    
    Route::get('/admin', [AdminController::class, 'getUsers']);

    Route::get('/contractors', [ContractorController::class, 'getData']);

    Route::get('/getContractor/{id}', [ContractorController::class, 'getContractor']);

    Route::post('/addContractor', [ContractorController::class, 'addContractor'])->name('addContractor'); 

    Route::post('/editContractor', [ContractorController::class, 'editContractor'])->name('editContractor'); 

    Route::get('/deleteContractor/{id}', [ContractorController::class, 'deleteContractor'])->name('deleteContractor');

    Route::get('/deleteuser/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

    Route::get('/getScanText', [ScanController::class, 'getData']);

    Route::get('/dictionary', [ScanController::class, 'userWords']);

    Route::post('/send', [FileController::class, 'sendScan'])->name('sendScan'); 

    Route::get('/deleteName/{id}', [ScanController::class, 'deleteName'])->name('deleteName');

    Route::post('/editFile', [FileController::class, 'editFile'])->name('editFile');

    Route::get('/deletefile/{id}', [FileController::class, 'deleteFile'])->name('deleteFile');

    Route::get('/removeRepetetive/{id}', [FileController::class, 'removeRepetetive'])->name('removeRepetetive');

    Route::post('/downloadAll', [FileController::class, 'downloadAll'])->name('downloadAll'); 

    Route::post('/sendEmail', [PHPMailerController::class, 'sendEmail'])->name('sendEmail'); 

    Route::post('/addScanner', [ScanController::class, 'addScanner'])->name('addScanner'); 
});
