<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageCourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MyCourseController;
use App\Models\ImageCourse;
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


Route::get('course', [CourseController::class, "index"]);
Route::post('course', [CourseController::class, "store"]);
Route::get('course/{id}', [CourseController::class, "show"]);
Route::put('course/{id}', [CourseController::class, "update"]);
Route::delete('course/{id}', [CourseController::class, "destroy"]);

Route::get("chapter", [ChapterController::class, "index"]);
Route::post('chapter', [ChapterController::class, "store"]);
Route::get('chapter/{id}', [ChapterController::class, "show"]);
Route::put('chapter/{id}', [ChapterController::class, "update"]);
Route::delete('chapter/{id}', [ChapterController::class, "destroy"]);

Route::get("lesson", [LessonController::class, "index"]);
Route::post('lesson', [LessonController::class, "store"]);
Route::get('lesson/{id}', [LessonController::class, "show"]);
Route::put('lesson/{id}', [LessonController::class, "update"]);
Route::delete('lesson/{id}', [LessonController::class, "destroy"]);

Route::post('image-course', [ImageCourseController::class, "store"]);
Route::delete('image-course/{id}', [ImageCourseController::class, "destroy"]);

Route::get("my-course", [MyCourseController::class, "index"]);
Route::post("my-course", [MyCourseController::class, "index"]);
Route::post("my-course/premium", [MyCourseController::class, "createPremiumAccess"]);
