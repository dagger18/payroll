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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/my-report', 'HomeController@myReport')->name('my-report');
Route::match(['get', 'post'], '/upload-avatar', 'HomeController@uploadAvatar')->name('uploadAvatar');
Route::get('/pdf/{id}', 'HomeController@pdf')->name('pdf');
Route::get('/avatar/{id}', 'HomeController@avatar')->name('avatar');
Route::get('/report/{id}', 'HomeController@report')->name('report');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => ['admin', 'superadmin']], function () {
  Route::get('/', 'AdminController@index');
  Route::resource('roles', 'RolesController');
  Route::resource('permissions', 'PermissionsController');
  Route::resource('users', 'UsersController');
  Route::resource('payroll', 'PayrollController');
  Route::resource('pages', 'PagesController');
  Route::resource('activitylogs', 'ActivityLogsController')->only([
      'index', 'show', 'destroy'
  ]);
  Route::get('/diagram', 'UsersController@diagram');
  Route::resource('settings', 'SettingsController');
  Route::get('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
  Route::post('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
});




Route::resource('admin/reports', 'Admin\\ReportsController');