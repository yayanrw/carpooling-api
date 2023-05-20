<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfficeController;
use App\Models\Vehicle;
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

    Route::resource('/company', CompanyController::class);
    Route::resource('/office', OfficeController::class);
    Route::resource('/vehicle', Vehicle::class);

    Route::get('/approval-requests', [ApprovalRequestController::class, 'index']);
    Route::get('/approval-requests/{approvalRequest}', [ApprovalRequestController::class, 'show']);
    Route::post('/approval-requests', [ApprovalRequestController::class, 'store']);
    Route::put('/approval-requests/{approvalRequest}', [ApprovalRequestController::class, 'update']);

    Route::get('/fuel-consumptions', [FuelConsumptionController::class, 'index']);
    Route::get('/fuel-consumptions/{fuelConsumption}', [FuelConsumptionController::class, 'show']);
    Route::post('/fuel-consumptions', [FuelConsumptionController::class, 'store']);

    Route::get('/service-schedules', [ServiceScheduleController::class, 'index']);
    Route::get('/service-schedules/{serviceSchedule}', [ServiceScheduleController::class, 'show']);
    Route::post('/service-schedules', [ServiceScheduleController::class, 'store']);
    Route::put('/service-schedules/{serviceSchedule}', [ServiceScheduleController::class, 'update']);

    Route::get('/vehicle-bookings', [VehicleBookingController::class, 'index']);
    Route::get('/vehicle-bookings/{vehicleBooking}', [VehicleBookingController::class, 'show']);
    Route::post('/vehicle-bookings', [VehicleBookingController::class, 'store']);
    Route::put('/vehicle-bookings/{vehicleBooking}', [VehicleBookingController::class, 'update']);
});
