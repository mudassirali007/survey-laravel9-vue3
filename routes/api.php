<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResource('question', QuestionController::class)->only([
        'index'
    ]);
    Route::apiResource('survey', SurveyController::class)->only([
        'index', 'store'
    ]);

    Route::get('/surveyTaken', [App\Http\Controllers\SurveyController::class, 'surveyTaken'])->name('surveyTaken');
    Route::get('/surveyStat', [App\Http\Controllers\SurveyController::class, 'surveyStat'])->name('surveyStat');

});


Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('usersList',  [App\Http\Controllers\UserController::class, 'index'])->name('usersList');
});

