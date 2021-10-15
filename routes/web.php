<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\MicropostsController;
use App\Http\Controllers\RelationshipsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [MicropostsController::class, 'index']);
Route::get('signup', [RegisterController::class, 'showRegistrationForm'])
    ->name('signup.get');
Route::post('signup', [RegisterController::class, 'register'])
    ->name('signup.post');
Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('login', [LoginController::class, 'login'])
    ->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])
    ->name('logout.get');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'users/{user}'], function () {
        Route::post('follow', [RelationshipsController::class, 'store'])
            ->name('user.follow');
        Route::delete('unfollow', [RelationshipsController::class, 'destroy'])
            ->name('user.unfollow');
        Route::get('followings', [UsersController::class, 'followings'])
            ->name('users.followings');
        Route::get('followers', [UsersController::class, 'followers'])
            ->name('users.followers');
        Route::get('favorites', [UsersController::class, 'favorites'])
            ->name('users.favorites');
    });
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);

    Route::group(['prefix' => 'microposts/{micropost}'], function () {
        Route::post('favorite', [FavoritesController::class, 'store'])
            ->name('favorites.favorite');
        Route::delete('favorite', [FavoritesController::class, 'destroy'])
            ->name('favorites.unfavorite');
    });
    Route::resource('microposts', MicropostsController::class, ['only' => ['store', 'destroy']]);
});
