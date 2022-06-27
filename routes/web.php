<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('recipe', RecipeController::class, ['except' => ['show', 'create']]);

Route::get('recipe/{id}', [RecipeController::class, 'show']); //recipes can be seen by unauthenticated users
Route::get('recipecreate', [RecipeController::class, 'create'])->middleware(['auth']);
Route::post('recipecreate', [RecipeController::class, 'store'])->middleware(['auth']);
Route::get('recipeedit', [RecipeController::class, 'edit'])->middleware(['auth']);

require __DIR__ . '/auth.php';
