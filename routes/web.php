<?php

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

//     path('profile/', views.ProfileView.as_view(), name='profile'),
//     path('requests/add', views.RequestsAddView.as_view(), name='add_request'),
//     path('requests/<id>/edit', views.RequestsEditView.as_view(), name='edit_request'),
//     path('requests/<id>/delete', views.RequestsDeleteView.as_view(), name='delete_request'),

Route::get('/', 'HomepageController@index')->name('index');

Auth::routes();
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile', 'ProfileController@store')->name('profile');

Route::get('/courts', 'CourtController@index')->name('courts');
Route::get('/courts/{id}', 'CourtController@show')->name('court');

Route::get('/players', 'CourtController@index')->name('players');
Route::get('/players/{id}', 'CourtController@show')->name('player');
Route::get('/players/{id}/message', 'CourtController@show')->middleware('auth')->name('message_player');

Route::get('/friends', 'CourtController@index')->name('friends');

Route::get('/admin', 'Admin\AdminController@index');
