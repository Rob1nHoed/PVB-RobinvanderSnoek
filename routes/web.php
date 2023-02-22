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

Route::get('/drink/{id}', [DrinkController::class, 'index'])->name('show.drink');
Route::get('/ingredient/{id}', [IngredientController::class, 'index'])->name('show.ingredient');

Route::get('/searchWithIngredients', [SearchWithIngredientsController::class, 'index'])->name('search.withIngredients');

Route::any('/search/results', [ShowWithNameController::class, 'index'])->name('show.searchResult');
Route::get('/search/resultsFromIngredients', [ShowWithIngredientsController::class, 'index'])->name('show.searchResultFromIngredients');

require __DIR__.'/auth.php';
