<?php

namespace App\Http\Controllers;

use App\Http\Requests\FuelConsumptionRequest;
use App\Models\FuelConsumption;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class FuelConsumptionController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('ability:super_admin,admin')->only(['store']);
    }

    public function index()
    {
        try {
            $fuelConsumption = FuelConsumption::withoutTrashed()->get();
            return $this->success($fuelConsumption);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(FuelConsumptionRequest $fuelConsumptionRequest)
    {
        try {
            $fuelConsumptionRequest->validated($fuelConsumptionRequest->all());

            $fuelConsumption = FuelConsumption::create([
                'vehicle_id' => $fuelConsumptionRequest->vehicle_id,
                'date' => $fuelConsumptionRequest->date,
                'litres' => $fuelConsumptionRequest->litres,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($fuelConsumption, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(FuelConsumption $fuelConsumption)
    {
        try {
            return $this->success($fuelConsumption);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
