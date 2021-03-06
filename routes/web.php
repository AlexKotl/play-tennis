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
Route::post('/courts/{id}/comment', 'CourtController@comment')->middleware('auth')->name('comment_court');

Route::get('/trainers', 'TrainerController@index')->name('trainers');
Route::get('/players', 'PlayerController@index')->name('players');
Route::get('/players/{id}', 'PlayerController@show')->name('player');
Route::post('/players/{id}/message', 'PlayerController@message')->middleware('auth')->name('message_player');

Route::get('/friends', 'FriendsController@index')->middleware('auth')->name('friends');

Route::get('/admin', 'Admin\AdminController@index');
