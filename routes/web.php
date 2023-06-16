<?php

use App\Http\Controllers\AnimalTreatmentController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\AnimalCategoryController;
use App\Http\Controllers\AllFarmAnimalsController;
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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;


Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify');
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');

    Route::get('animal-categories', [AnimalCategoryController::class, 'show'])->name('animal-categories');
    Route::post('/save-animal-category', [AnimalCategoryController::class, 'save'])->name('saveAnimalCategory');
    Route::get('/animal-categories/{id}/find', [AnimalCategoryController::class, 'find'])->name('animal-categories.find');
    Route::put('/animal-categories/{id}/update', [AnimalCategoryController::class, 'update'])->name('animal-categories.update');
    Route::get('/animal-categories/{id}/delete', [AnimalCategoryController::class, 'delete'])->name('animal-categories.delete');
    Route::get('breeds', [BreedController::class, 'populateBreeds'])->name('breeds');
    Route::post('/save-breed', [BreedController::class, 'save'])->name('saveBreed');
    Route::get('/breeds/{id}/find', [BreedController::class, 'find'])->name('breeds.find');
    Route::put('/breeds/{id}/update', [BreedController::class, 'update'])->name('breeds.update');
    Route::get('/breeds/{id}/delete', [BreedController::class, 'delete'])->name('breeds.delete');
    Route::get('animals', [AllFarmAnimalsController::class, 'index'])->name('animals');
    Route::post('/save-animal', [AllFarmAnimalsController::class, 'save'])->name('saveAnimal');
    Route::get('/animal/{id}/find', [AllFarmAnimalsController::class, 'find'])->name('animal.find');
    Route::get('/animal/{id}/view', [AllFarmAnimalsController::class, 'view'])->name('animal.view');
    Route::put('/animal/{id}/update', [AllFarmAnimalsController::class, 'update'])->name('animal.update');
    Route::get('/animal/{id}/delete', [AllFarmAnimalsController::class, 'delete'])->name('animal.delete');
    Route::get('animalTreatment', [AnimalTreatmentController::class, 'index'])->name('animalTreatment');
    Route::post('/save-animal-treatment', [AnimalTreatmentController::class, 'save'])->name('saveAnimalTreatment');
    Route::get('/animalTreatment/{id}/find', [AnimalTreatmentController::class, 'find'])->name('animalTreatment.find');
    Route::get('/animalTreatment/{id}/view', [AnimalTreatmentController::class, 'view'])->name('animalTreatment.view');
    Route::put('/animalTreatment/{id}/update', [AnimalTreatmentController::class, 'update'])->name('animalTreatment.update');
    Route::get('/animalTreatment/{id}/delete', [AnimalTreatmentController::class, 'delete'])->name('animalTreatment.delete');

    Route::get('log-viewer', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('log-viewer');


    Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});
