<?php

use App\Models\AdoptionPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnimalsController;
use App\Http\Controllers\CentersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdoptionPlanController;

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
