<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\NotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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





 Route::group(['prefix' => 'v1'],function(){

   Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::post('notes',[NotesController::class,'store']);
    Route::get('notes',[NotesController::class,'index']);
    Route::put('notes/{id}',[NotesController::class,'update']);
    Route::delete('notes/{id}',[NotesController::class,'destroy']);
   });

    Route::group(['prefix' => 'auth'],function(){
        Route::post('register',[AuthenticationController::class,'Registrasi']);
        Route::post('login',[AuthenticationController::class,'Login']);
    });

 });
