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

Route::get('/', function () {return view('welcome');});
Route::get('/calendar','CalendarController@index2');


// Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
// Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
// Route::prefix('auth')->middleware('guest')->group(function() {

//    Route::get('/{provider}', 'Auth\OAuthController@socialOAuth')
//        ->where('provider','google')
//        ->name('socialOAuth');

//     Route::get('/{provider}/callback', 'Auth\OAuthController@handleProviderCallback')
//         ->where('provider','google')
//         ->name('oauthCallback');
// });
Route::get('/holiday','CalendarController@getHoliday');
Route::post('/holiday','CalendarController@postHoliday');
Route::get('/holiday/{id}','CalendarController@getHolidayId');
Route::delete('/holiday','CalendarController@deleteHoliday');




Route::resource('tasks', 'TasksController')->only([
    'index', 'store', 'edit', 'update', 'destroy']);


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'TasksController@index')->name('home');
//Route::get('/calendar', 'calendar@renderCalendar');
//Route::get('/','CalendarController@index2');
Route::get('/maptop','MapController@index3');
Route::get('/show/{id}','MapController@getMap');
Route::post('/map','MapController@postMap');

Route::get('chat', 'ChatController@index4');
Route::get('ajax/chat', 'Ajax\ChatController@index4'); // メッセージ一覧を取得
Route::post('ajax/chat', 'Ajax\ChatController@create'); // チャット登録

Route::group(['middleware' => 'auth'], function(){
Route::get('video_chat', 'VideoChatController@index5');      // チャットページ
Route::post('auth/video_chat', 'VideoChatController@auth'); // 認証ページ
});