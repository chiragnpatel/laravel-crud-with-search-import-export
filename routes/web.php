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

use App\Students;
use Illuminate\Support\Facades\Input;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'StudentController@index')->name('index');

Route::get('/file-import', 'StudentController@fileImport')->name('file-import');

Route::get('/create', 'StudentController@create')->name('create');

Route::post('/store', 'StudentController@store')->name('store');

Route::get('/show/{id}', 'StudentController@show')->name('show');

Route::get('/edit/{id}', 'StudentController@edit')->name('edit');

Route::patch('/update/{id}', 'StudentController@update')->name('update');

Route::any('/destroy/{id}', 'StudentController@destroy')->name('destroy');

Route::post('import', 'StudentController@import')->name('import');

Route::get('export', 'StudentController@export')->name('export');

Route::any('/search', function () {
    $q = Input::get('q');
    $students = Students::where('first_name', 'LIKE', '%' . $q . '%')->orWhere('sdr', 'LIKE', '%' . $q . '%')->get();
    if (count($students) > 0)
        return view('search')->with('student', $students);
    else
        return view('search')->with('message','No Details found. Try to search again !');
});