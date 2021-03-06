<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicReportController;

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
//     return view('welcome');
// });

Route::get('/', [ClinicReportController::class, 'index']);
Route::post('report', [ClinicReportController::class, 'store'])->name('report');
Route::get('/report/pdf/{id}', [ClinicReportController::class, 'exportPDF']);
Route::get('/reports', [ClinicReportController::class, 'exportCSV']);