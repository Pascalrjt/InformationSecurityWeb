<?php

use App\Models\AdoptionPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnimalsController;
use App\Http\Controllers\CentersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdoptionPlanController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileRequestController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\DigitalSignatureController;
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

Route::get('/', function () {
    return view('home');
});

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile');


//Route::get('/animals/create', [AnimalsController::class, 'create']);
Route::get('/animals', [AnimalsController::class, 'index']);
Route::post('/animals', [AnimalsController::class, 'store']);
Route::get('/animals/create', [AnimalsController::class, 'create'])->middleware('App\Http\Middleware\Admin');
Route::get('/animals/{animals_id}', [AnimalsController::class, 'show']);
Route::get('/animals/{animals_id}/edit', [AnimalsController::class, 'edit'])->middleware('App\Http\Middleware\Admin');
Route::put('/animals/{animals_id}', [AnimalsController::class, 'update']);
Route::delete('/animals/{animals_id}', [AnimalsController::class, 'destroy'])->middleware('App\Http\Middleware\Admin');

Route::get('/center/create', [CentersController::class, 'create'])->middleware('App\Http\Middleware\Admin');
Route::get('/center', [CentersController::class, 'index']);
Route::post('/center', [CentersController::class, 'store']);
Route::get('/center/{centers_id}', [CentersController::class, 'show']);
Route::get('/center/{center_id}/edit', [CentersController::class, 'edit']);
Route::put('/center/{center_id}', [CentersController::class, 'update']);
Route::delete('/center/{centers}', [CentersController::class, 'destroy'])->middleware('App\Http\Middleware\Admin');

Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

//Route::post('/', [AdoptionPlanController::class, 'store'])->middleware('auth')->name('adoptionplan.store');
//Route::post('/', [AdoptionPlanController::class, 'store'])->middleware('auth')->name('adoptionplan.store');
Route::post('/animals/{animals}', [AdoptionPlanController::class, 'store'])->middleware('auth')->name('adoptionplan.store');

Route::get('/files/create', [FilesController::class, 'upload'])->name('upload')->middleware('App\Http\Middleware\Admin');
Route::get('/files', [FilesController::class, 'index'])->name('files.index');
Route::post('/files', [FilesController::class, 'store'])->name('files.store');
Route::get('/files/download/{id}', [FilesController::class, 'download'])->name('files.download');
Route::post('/files/{file}/decrypt', [FilesController::class, 'decryptWithKey'])->name('files.decryptWithKey');


Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::post('/users', [FileRequestController::class, 'store'])->middleware('auth')->name('filerequest.store');

Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
Route::put('/filerequests/{fileRequest}', 'FileRequestController@update')->name('filerequests.update');
Route::post('/filerequests/{requested}', [FileRequestController::class, 'store'])->name('filerequests.store');
Route::put('/filerequests/{fileRequest}', [FileRequestController::class, 'update'])->name('filerequests.update');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/digitalsignature', function () {
        return view('digitalsignature.index');
    });

    Route::get('/digitalsignature/create', function () {
        return view('digitalsignature.create');
    });

    Route::post('/digitalsignature/download', 'App\Http\Controllers\DigitalSignatureController@downloadPdf');
});
