<?php

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



use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ProjectMessageController;
use App\Http\Controllers\PrivateChatController;
use App\Http\Controllers\PrivateMessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectRequestController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);



Route::post('/projects/{project_id}/request', [ProjectRequestController::class, 'store']);
Route::post('/requests/{request_id}/respond', [ProjectRequestController::class, 'respond']);
Route::get('/notifications', [NotificationController::class, 'index']); // Notificaciones del usuario logueado
    Route::get('/project-requests', [ProjectRequestController::class, 'index']); // Requests del usuario logueado
});

Route::get('/projects/batch', [ProjectController::class, 'getProjectBatch']);
// Rutas para Usuarios

Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Rutas para Proyectos
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

// Rutas para miembros de proyecto
Route::post('/projects/{projectId}/members/{userId}', [ProjectMemberController::class, 'addUserToProject']);
Route::delete('/projects/{projectId}/members/{userId}', [ProjectMemberController::class, 'removeUserFromProject']);
Route::get('/projects/{projectId}/members', [ProjectMemberController::class, 'getProjectMembers']);

// Rutas para mensajes de proyectos
Route::get('/projects/{projectId}/messages', [ProjectMessageController::class, 'index']);
Route::post('/projects/{projectId}/messages', [ProjectMessageController::class, 'store']);

// Rutas para chats privados
Route::get('/private-chats', [PrivateChatController::class, 'index']);
Route::post('/private-chats', [PrivateChatController::class, 'store']);

// Rutas para mensajes privados
Route::get('/private-chats/{chatId}/messages', [PrivateMessagesController::class, 'index']);
Route::post('/private-chats/{chatId}/messages', [PrivateMessagesController::class, 'store']);



// Rutas para eventos
Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::put('/events/{id}', [EventController::class, 'update']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);

