<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/create-user', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::get("/courses", [CourseController::class, 'index']);
Route::post('/courses', [CourseController::class, 'store']);
Route::get("/levels", [LevelController::class, 'index']);

Route::get("/subjects/{levelId}/{courseId}/", [SubjectController::class, "getByLevelAndCourse"]);
Route::post("/add-subject", [SubjectController::class, "addSubject"]);


Route::post("/add-student", [StudentController::class, 'addStudent']);
Route::get("/students/block/{blockId}", [StudentController::class, 'getByBlock']);
Route::post("/students/update", [StudentController::class, 'update']);
Route::get("/students/level/{level}", [StudentController::class, 'getStudentByLevel']);

Route::get("/exams/get-by-s/{subjectID}", [ExamController::class, "getExamsBySubject"]);
Route::post("/exams/add", [ExamController::class, "addExam"]);
Route::post("/exams/add-score", [ExamController::class, "addStudentScore"]);
Route::get("/exams/get-by-l/{level_id}", [ExamController::class, "getExamsByLevel"]);
Route::get('/exams/scores/{examId}/{levelId}', [ExamController::class, 'getScoresByExamAndLevel']);


Route::post("/attendance/mark", [AttendanceController::class, "markAsPresent"]);
Route::get("/attendance", [AttendanceController::class, "index"]);


Route::post('/blocks', [BlockController::class, 'store']);
Route::get('/blocks/{levelId}/{courseId}', [BlockController::class, 'getByLevelAndCourse']);