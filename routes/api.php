<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['controller' => StudentController::class],function () {
    Route::get('/students','index');
    Route::post('/students','store');
    Route::get('/students/{studentId}','show');
    Route::get('/students/{studentId}/edit','edit');
    Route::put('/students/{studentId}/edit','update');
    Route::delete('/students/{studentId}/delete','destroy');
});

