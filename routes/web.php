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

// path('', views.IndexView.as_view(), name='index'),
//     path('', include('django.contrib.auth.urls')),
//     path('players/', views.PlayersView.as_view(), name='players'),
//     path('players/<id>', views.PlayerView.as_view(), name='player'),
//     path('players/<id>/message', views.MessageView.as_view(), name='message_player'),
//     path('courts/', views.CourtsView.as_view(), name='courts'),
//     path('courts/<id>', views.CourtView.as_view(), name='court'),
//     path('friends/', views.FriendsView.as_view(), name='friends'),
//     path('register/', views.RegisterView.as_view(), name='register'),
//     path('profile/', views.ProfileView.as_view(), name='profile'),
//     path('requests/add', views.RequestsAddView.as_view(), name='add_request'),
//     path('requests/<id>/edit', views.RequestsEditView.as_view(), name='edit_request'),
//     path('requests/<id>/delete', views.RequestsDeleteView.as_view(), name='delete_request'),
//     path('sitemap.xml', views.SitemapView.as_view(), name='sitemap'),
//     path('admin/', admin.site.urls),

Route::get('/', function () {
    return view('layouts.app');
})->name('index');
//Route::get('/players', 'UserController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
