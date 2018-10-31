<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::get('/endpoint', function (Request $request) {
//     //
// });

Route::get('/get_databases', 'Naif\NovaMysql\Http\Controllers\cPanelController@getDatabases');
Route::post('/create_database', 'Naif\NovaMysql\Http\Controllers\cPanelController@createDatabase');
Route::post('/delete_database', 'Naif\NovaMysql\Http\Controllers\cPanelController@deleteDatabase');
Route::post('/repair_database', 'Naif\NovaMysql\Http\Controllers\cPanelController@repairDatabase');
Route::get('/get_users', 'Naif\NovaMysql\Http\Controllers\cPanelController@getUsers');
Route::post('/add_user', 'Naif\NovaMysql\Http\Controllers\cPanelController@addUser');
Route::post('/delete_user', 'Naif\NovaMysql\Http\Controllers\cPanelController@deleteUser');
Route::post('/change_password', 'Naif\NovaMysql\Http\Controllers\cPanelController@changeUserPassword');
Route::post('/add_user_to_database', 'Naif\NovaMysql\Http\Controllers\cPanelController@addUserToDatabase');
Route::get('/get_user_privileges', 'Naif\NovaMysql\Http\Controllers\cPanelController@getUserPrivileges');
Route::post('/revoke_database_user', 'Naif\NovaMysql\Http\Controllers\cPanelController@revokeDatabaseUser');
