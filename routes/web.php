<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QouteController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;


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

Route::get('/', function () {
    return Redirect::to('login');
});

Route::get('/checkpassword', function(){
    return Hash::check('Test@1234', '$2y$10$Lgsd4UexYHOb0Nh6g0SU2ecdlNArYWBO.dH/J5yykmwclIK14xYtu');
});


Route::get('/settings', function () {
    return Redirect::to('/qoutes');
})->middleware(['auth'])->name('settings');

Route::get('/profile', [ProfileController::class, 'index'])->middleware(['auth'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->middleware(['auth'])->name('profile.update');
Route::put('/profile/setLogo', [ProfileController::class, 'setLogo'])->name('setLogo');

Route::resource('qoutes', QouteController::class)->middleware(['auth']);

Route::post('/qoutes/addImage', [QouteController::class, 'addImage'])->name('addImage');
Route::post('/qoutes/delImage', [QouteController::class, 'delImage'])->name('delImage');
Route::get('/qoute/{qoute}/ac/{access_code}', [QouteController::class, 'show']);
Route::get('/qoute/{qoute}/ac/{access_code}/create-pdf', [QouteController::class, 'createPdf']);
Route::get('/qoute/{qoute}/ac/{access_code}/export-excel', [QouteController::class, 'exportExcel']);

Route::get('lang/{lang}',[LanguageController::class, 'switchLang'])->name('lang.switch');
Route::post('/qoutes/file-upload', [QouteController::class, 'dropzoneFileUpload' ])->name('dropzoneFileUpload');

require __DIR__.'/auth.php';
