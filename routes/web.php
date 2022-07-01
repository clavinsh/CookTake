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



Route::resource('recipe', RecipeController::class, ['except' => ['create', 'edit', 'home', 'showSearch']]);
Route::get('admin_dashboard', [RecipeController::class, 'adminPage'])->middleware(['auth', 'admin'])->name('admin_dashboard');
Route::get('home', [RecipeController::class, 'home'])->middleware(['user'])->name('home');
Route::get('recipe/{id}', [RecipeController::class, 'show'])->name('recipe'); //recipes can be seen by unauthenticated users
Route::get('recipecreate', [RecipeController::class, 'create'])->middleware(['auth'])->name('recipecreate');
Route::post('recipecreate', [RecipeController::class, 'store'])->middleware(['auth']);
Route::get('recipeedit/{id}', [RecipeController::class, 'edit'])->middleware(['auth'])->name('recipeedit');
Route::put('recipeedit/{id}', [RecipeController::class, 'update'])->middleware(['auth']);
Route::get('recipesearch', [RecipeController::class, 'showSearch'])->name('recipesearch');
Route::post('recipesearch', [RecipeController::class, 'search']);

Route::resource('tag', TagController::class, ['except' => ['index', 'tagcreate', 'tagfollow']]);
Route::get('tags', [TagController::class, 'index']);
Route::get('tagcreate', [TagController::class, 'create'])->middleware(['auth']);
Route::post('tagcreate', [TagController::class, 'store'])->middleware(['auth']);
Route::get('tagrecipes/{id}', [TagController::class, 'show'])->name('tagrecipes');
Route::post('tagfollow/{id}', [TagController::class, 'followTag'])->middleware(['auth'])->name('followTag');
Route::post('tagunfollow/{id}', [TagController::class, 'unfollowTag'])->middleware(['auth'])->name('unfollowTag');


require __DIR__ . '/auth.php';
