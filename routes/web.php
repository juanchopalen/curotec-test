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
    return view('welcome');
});


Route::get('/datatable', 'DatatablesController@getIndex')->name('index');
Route::get('/anyData', 'DatatablesController@anydata')->name('datatables.data');

Route::post('/save_survey', 'SurveyController@assignUser')->name('survey.assign_user');

Route::get('/survey', function(){
    return view('survey');
});


Route::prefix('api')->group(function (){
    Route::get('survey', 'SurveyController@index')->name('survey.index');
    Route::put('survey/{id}', 'SurveyController@update')->name('survey.update');
    Route::post('survey', 'SurveyController@store')->name('survey.store');
    Route::delete('survey/{id}', 'SurveyController@delete')->name('survey.delete');
});