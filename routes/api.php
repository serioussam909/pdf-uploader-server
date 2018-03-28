<?php

use Illuminate\Http\Request;
use App\Document;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('documents', 'DocumentController@index');
Route::get('documents/{document}', 'DocumentController@show');
Route::get('documents/{document}/attachment', 'DocumentController@showAttachment');
Route::get('documents/{document}/attachment/preview', 'DocumentController@showPreview');
Route::post('documents', 'DocumentController@store');
