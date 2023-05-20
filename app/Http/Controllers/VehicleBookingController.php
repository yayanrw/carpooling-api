<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleBookingRequest;
use App\Http\Requests\UpdateVehicleBookingRequest;
use App\Models\VehicleBooking;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class VehicleBookingController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $vehicleBooking = VehicleBooking::withoutTrashed()->get();
            return $this->success($vehicleBooking);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreVehicleBookingRequest $storeVehicleBookingRequest)
    {
        try {
            $storeVehicleBookingRequest->validated($storeVehicleBookingRequest->all());

            $vehicleBooking = VehicleBooking::create([
                'vehicle_id' => $storeVehicleBookingRequest->vehicle_id,
                'driver_id' => $storeVehicleBookingRequest->driver_id,
                'user_request_id' => $storeVehicleBookingRequest->user_request_id,
                'estimation_start_date' => $storeVehicleBookingRequest->estimation_start_date,
                'estimation_completion_date' => $storeVehicleBookingRequest->estimation_completion_date,
                'neccesary' => $storeVehicleBookingRequest->neccesary,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($vehicleBooking, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        try {
            $vehicleBooking = VehicleBooking::find($id);

            if (!empty($vehicleBooking)) {
                return $this->success($vehicleBooking);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateVehicleBookingRequest $updateVehicleBookingRequest, int $id)
    {
        try {
            $vehicleBooking = VehicleBooking::find($id);

            if (!empty($vehicleBooking)) {
                $vehicleBooking->actual_start_date = $updateVehicleBookingRequest->actual_start_date;
                $vehicleBooking->actual_completion_date = $updateVehicleBookingRequest->actual_completion_date;
                $vehicleBooking->status = $updateVehicleBookingRequest->status;
                $vehicleBooking->updated_by = Auth::user()->id;

                $vehicleBooking->save();

                return $this->success($vehicleBooking, MyApp::UPDATED_SUCCESSFULLY);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
