<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [RestaurantController::class, 'index'])->name('index');
Route::get('/search', [RestaurantController::class, 'search'])->name('search');
Route::get('/pickUp', [RestaurantController::class, 'pickUp'])->name('pickUp');
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurant_detail');
Route::get('/savedList', [RestaurantController::class, 'savedList'])->name('saved_list');
Route::post('/saved/{restaurantId}/{email}', [RestaurantController::class, 'saved'])->name('saved');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
