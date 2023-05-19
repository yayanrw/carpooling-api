<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use App\MyApp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $vehicle = Vehicle::withoutTrashed()->get();
            return $this->success($vehicle);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(VehicleRequest $vehicleRequest)
    {
        try {
            $vehicleRequest->validated($vehicleRequest->all());

            $vehicle = Vehicle::create([
                'company_id' => $vehicleRequest->company_id,
                'office_id' => $vehicleRequest->office_id,
                'license_plate' => $vehicleRequest->license_plate,
                'hull_number' => $vehicleRequest->hull_number,
                'type' => $vehicleRequest->type,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($vehicle, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        try {
            $vehicle = Vehicle::find($id);

            if (!empty($vehicle)) {
                return $this->success($vehicle);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(VehicleRequest $vehicleRequest, int $id)
    {
        try {
            $vehicle = Vehicle::find($id);

            if (!empty($vehicle)) {
                $vehicle->company_id = $vehicleRequest->company_id;
                $vehicle->office_id = $vehicleRequest->office_id;
                $vehicle->license_plate = $vehicleRequest->license_plate;
                $vehicle->hull_number = $vehicleRequest->hull_number;
                $vehicle->type = $vehicleRequest->type;
                $vehicle->updated_by = Auth::user()->id;

                $vehicle->save();

                return $this->success($vehicle, MyApp::UPDATED_SUCCESSFULLY);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $vehicle = Vehicle::find($id);

            if (!empty($vehicle)) {
                $vehicle->deleted_by = Auth::user()->id;
                $vehicle->save();
                $vehicle->delete();

                return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
