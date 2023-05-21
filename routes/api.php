<?php

use App\Http\Controllers\ApprovalRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FuelConsumptionController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ServiceScheduleController;
use App\Http\Controllers\VehicleBookingController;
use App\Http\Controllers\VehicleController;
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

// Public routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
});

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/approval-requests', [ApprovalRequestController::class, 'index']);
    Route::get('/approval-requests/{approvalRequest}', [ApprovalRequestController::class, 'show']);
    Route::post('/approval-requests', [ApprovalRequestController::class, 'store']);
    Route::put('/approval-requests/{approvalRequest}', [ApprovalRequestController::class, 'update']);

    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/companies/{company}', [CompanyController::class, 'show']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::put('/companies/{company}', [CompanyController::class, 'update']);
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);

    Route::get('/fuel-consumptions', [FuelConsumptionController::class, 'index']);
    Route::get('/fuel-consumptions/{fuelConsumption}', [FuelConsumptionController::class, 'show']);
    Route::post('/fuel-consumptions', [FuelConsumptionController::class, 'store']);

    Route::get('/offices', [OfficeController::class, 'index']);
    Route::get('/offices/{office}', [OfficeController::class, 'show']);
    Route::post('/offices', [OfficeController::class, 'store']);
    Route::put('/offices/{office}', [OfficeController::class, 'update']);
    Route::delete('/offices/{office}', [OfficeController::class, 'destroy']);

    Route::get('/service-schedules', [ServiceScheduleController::class, 'index']);
    Route::get('/service-schedules/{serviceSchedule}', [ServiceScheduleController::class, 'show']);
    Route::post('/service-schedules', [ServiceScheduleController::class, 'store']);
    Route::put('/service-schedules/{serviceSchedule}', [ServiceScheduleController::class, 'update']);

    Route::get('/vehicle-bookings', [VehicleBookingController::class, 'index']);
    Route::get('/vehicle-bookings/{vehicleBooking}', [VehicleBookingController::class, 'show']);
    Route::post('/vehicle-bookings', [VehicleBookingController::class, 'store']);
    Route::put('/vehicle-bookings/{vehicleBooking}', [VehicleBookingController::class, 'update']);

    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy']);
});
