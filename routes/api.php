<?php

use App\Http\Controllers\MentorController;
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

Route::get('mentor', [MentorController::class, "index"]);
Route::get('mentor/{id}', [MentorController::class, "show"]);
Route::post('mentor', [MentorController::class, "store"]);
Route::put('mentor/{id}', [MentorController::class, "update"]);
Route::delete('mentor/{id}', [MentorController::class, "destroy"]);