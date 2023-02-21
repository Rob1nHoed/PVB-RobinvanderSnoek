<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\SearchWithIngredientsController;
use App\Http\Controllers\ShowWithIngredientsController;
use App\Http\Controllers\ShowWithNameController;

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

Route::get('/', [HomepageController::class, 'index'])->name('home');

Route::get('/drink/{id}', [DrinkController::class, 'index'])->name('drink');
Route::get('/ingredient/{id}', [IngredientController::class, 'index'])->name('ingredient');

Route::get('/searchWithIngredients', [SearchWithIngredientsController::class, 'index'])->name('search');

Route::post('/search/results', [ShowWithNameController::class, 'index'])->name('search');
Route::post('/search/results', [ShowWithIngredientsController::class, 'index'])->name('searchWithIngredients');

require __DIR__.'/auth.php';
