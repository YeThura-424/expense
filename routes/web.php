<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\TotalController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BorrowtotalController;
use App\Http\Controllers\LendController;
use App\Http\Controllers\LendtotalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('uselisting');
// });
Route::get('admin/', [HomeController::class, 'index'])->name('admin.home')->middleware('is_admin');
Route::middleware(['is_admin'])->group(function () {

    Route::resources([
        'form' => FormController::class,
    ]);
    Route::resources([
        'category' => CategoryController::class,
    ]);
    Route::resources([
        'total' => TotalController::class,
    ]);
    Route::resources([
        'borrow' => BorrowController::class,
    ]);
    Route::resources([
        'borrowtotal' => BorrowtotalController::class,
    ]);
    Route::resources([
        'lend' => LendController::class,
    ]);
    Route::resources([
        'lendtotal' => LendtotalController::class,
    ]);
    Route::resources([
        'income' => IncomeController::class,
    ]);

    // Form
    Route::get('detailreport', [FormController::class, 'detailreport'])->name('detailreport');
    Route::get('excelexport', [FormController::class, 'excelexport'])->name('excelexport');
    Route::get('pdfexport', [FormController::class, 'pdfexport'])->name('pdfexport');
    Route::post('excelimport', [FormController::class, 'excelimport'])->name('excelimport');
    // Total
    Route::get('report', [FormController::class, 'report'])->name('report');
    Route::get('totalexport', [FormController::class, 'totalexport'])->name('totalexport');
    Route::get('totalpdfexport', [FormController::class, 'totalpdfexport'])->name('totalpdfexport');
    // Income
    Route::get('incomereport', [IncomeController::class, 'incomereport'])->name('incomereport');
    Route::get('incomeexport', [IncomeController::class, 'incomeexport'])->name('incomeexport');
    Route::get('incomepdfexport', [IncomeController::class, 'incomepdfexport'])->name('incomepdfexport');
    Route::post('incomeimport', [IncomeController::class, 'incomeimport'])->name('incomeimport');
    // Lend
    Route::get('lendreport', [LendController::class, 'lendreport'])->name('lendreport');
    Route::get('lendexport', [LendController::class, 'lendexport'])->name('lendexport');
    Route::get('lendpdfexport', [LendController::class, 'lendpdfexport'])->name('lendpdfexport');
    Route::post('lendimport', [LendController::class, 'lendimport'])->name('lendimport');
    // Borrow
    Route::get('borrowreport', [BorrowController::class, 'borrowreport'])->name('borrowreport');
    Route::get('borrowexport', [BorrowController::class, 'borrowexport'])->name('borrowexport');
    Route::get('borrowpdfexport', [BorrowController::class, 'borrowpdfexport'])->name('borrowpdfexport');
    Route::post('borrowimport', [BorrowController::class, 'borrowimport'])->name('borrowimport');
    //Calreports
    Route::get('pmreport',[HomeController::class, 'pmreport'])->name('pmreport');
});

// Route::post('file-upload', [FileUploadController::class, 'fileUploadPost'])->name('file.upload.post');
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
