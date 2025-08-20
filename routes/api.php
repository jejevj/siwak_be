<?php

use App\Http\Controllers\Api\TTaskSurveyController;
use App\Http\Controllers\Api\TTaskSurveyDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirWakafController;

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


Route::apiResource('task-survey-details', TTaskSurveyDetailController::class);

Route::apiResource('task-survey', TTaskSurveyController::class);
Route::get('task-survey-data', function (Request $request) {
    $taskId = $request->query('task_id');

    if (!$taskId) {
        return response()->json(['error' => 'task_id is required'], 422);
    }

    return \App\Models\TTaskSurveyDetail::where('task_id', $taskId)->get();
});
Route::post('login', [AuthController::class, 'login']);


Route::post('dir-wakaf', [DirWakafController::class, 'index']);
Route::get('dir-wakaf/{id}', [DirWakafController::class, 'show']);
Route::put('dir-wakaf/{id}', [DirWakafController::class, 'update']);
Route::delete('dir-wakaf/{id}', [DirWakafController::class, 'destroy']);
