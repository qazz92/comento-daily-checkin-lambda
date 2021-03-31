<?php

use Illuminate\Http\Request;

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


Route::get('/welcome',function () {
    return response()->json(['msg'=>'hello, world!','user'=>\App\Models\User::inRandomOrder()->first()]);
});

Route::get('/getSignedUrl',[\App\Http\Controllers\FileController::class,'getSignedUrl']);


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user/me',[\App\Http\Controllers\UserController::class,'me']);

    Route::get('/emotion',[\App\Http\Controllers\EmotionController::class,'list']);

    Route::get('/answer',[\App\Http\Controllers\AnswerController::class,'list']);
    Route::get('/answer/{id}',[\App\Http\Controllers\AnswerController::class,'show']);
    Route::post('/answer',[\App\Http\Controllers\AnswerController::class,'create']);
    Route::patch('/answer',[\App\Http\Controllers\AnswerController::class,'update']);
    Route::delete('/answer',[\App\Http\Controllers\AnswerController::class,'delete']);

    Route::post('/comment',[\App\Http\Controllers\CommentController::class,'create']);
    Route::patch('/comment',[\App\Http\Controllers\CommentController::class,'update']);
    Route::delete('/comment',[\App\Http\Controllers\CommentController::class,'delete']);

    Route::post('/like',[\App\Http\Controllers\LikeController::class,'create']);
    Route::delete('/like',[\App\Http\Controllers\LikeController::class,'delete']);

    Route::get('/notice',[\App\Http\Controllers\NoticeController::class,'list']);
    Route::get('/notice/{id}',[\App\Http\Controllers\NoticeController::class,'show']);
    Route::post('/notice',[\App\Http\Controllers\NoticeController::class,'create']);
    Route::patch('/notice',[\App\Http\Controllers\NoticeController::class,'update']);
    Route::delete('/notice',[\App\Http\Controllers\NoticeController::class,'delete']);



});


