<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\TagController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', 'home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('recipe', RecipeController::class, ['except' => ['create', 'edit']]);
Route::get('home', [RecipeController::class, 'home']);
Route::get('recipe/{id}', [RecipeController::class, 'show']); //recipes can be seen by unauthenticated users
Route::get('recipecreate', [RecipeController::class, 'create'])->middleware(['auth']);
Route::post('recipecreate', [RecipeController::class, 'store'])->middleware(['auth']);
Route::get('recipeedit/{id}', [RecipeController::class, 'edit'])->middleware(['auth']);
Route::put('recipeedit/{id}', [RecipeController::class, 'update'])->middleware(['auth']);

Route::resource('tag', TagController::class, ['except' => ['index', 'tagcreate']]);
Route::get('tags', [TagController::class, 'index']);
Route::get('tagcreate', [TagController::class, 'create'])->middleware(['auth']);
Route::post('tagcreate', [TagController::class, 'store'])->middleware(['auth']);



require __DIR__ . '/auth.php';
