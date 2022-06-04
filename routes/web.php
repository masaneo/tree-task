<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreeNodeController;

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
    return view('welcome');
});

Route::get('/tree', 'App\Http\Controllers\TreeNodeController@showTree');
Route::post('/add', 'App\Http\Controllers\TreeNodeController@insertNode');
Route::delete('/delete', 'App\Http\Controllers\TreeNodeController@deleteNode');
Route::put('/edit', 'App\Http\Controllers\TreeNodeController@editNode');
Route::put('/move', 'App\Http\Controllers\TreeNodeController@moveNode');
