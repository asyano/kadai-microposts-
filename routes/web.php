<?php

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

Route::get('/', 'MicropostsController@index');
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
         Route::post('favorite', 'FavoriteController@store')->name('user.favorite'); //いいね
        Route::delete('unfavorite', 'FavoriteController@destroy')->name('user.unfavorite');//いいね解除
        Route::get('favoritings', 'UsersController@favoritings')->name('users.favoritings');//このユーザがいいねしたつぶやきを表示
        // Route::get('favowers', 'FavoriteController@followers')->name('users.favowers'); //このつぶやきをいいねしたユーザを表示
         
    });


 // 追加
    Route::group(['prefix' => 'microposts/{id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
    });
    
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});


// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
