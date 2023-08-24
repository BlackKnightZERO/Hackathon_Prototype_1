<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MinistryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TicketController;
use App\Enums\ApproveStatusEnum;
use App\Enums\TicketStatusEnum;

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

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
	Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::apiResource('/ministries', MinistryController::class);
    Route::apiResource('/modules', ModuleController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/permissions', PermissionController::class);
    Route::apiResource('/role-permissions', RolePermissionController::class);
    Route::apiResource('/tickets', TicketController::class);

    Route::get('/get-approve-status', function() {
        return response()->json([
            'data' => ApproveStatusEnum::cases(),
        ]);
    });
    Route::get('/get-ticket-status', function() {
        return response()->json([
            'data' => TicketStatusEnum::cases(),
        ]);
    });
});