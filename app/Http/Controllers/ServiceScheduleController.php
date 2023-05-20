<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceScheduleRequest;
use App\Http\Requests\UpdateServiceScheduleRequest;
use App\Models\ServiceSchedule;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServiceScheduleController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('ability:super_admin,admin')->only(['store', 'update']);
    }

    public function index()
    {
        try {
            $serviceSchedule = ServiceSchedule::withoutTrashed()->get();
            return $this->success($serviceSchedule);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreServiceScheduleRequest $storeServiceScheduleRequest)
    {
        try {
            $storeServiceScheduleRequest->validated($storeServiceScheduleRequest->all());

            $serviceSchedule = ServiceSchedule::create([
                'vehicle_id' => $storeServiceScheduleRequest->vehicle_id,
                'estimation_date' => $storeServiceScheduleRequest->estimation_date,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($serviceSchedule, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(ServiceSchedule $serviceSchedule)
    {
        try {
            return $this->success($serviceSchedule);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateServiceScheduleRequest $updateServiceScheduleRequest, ServiceSchedule $serviceSchedule)
    {
        try {
            $serviceSchedule->vehicle_id = $updateServiceScheduleRequest->vehicle_id;
            $serviceSchedule->actual_date = $updateServiceScheduleRequest->actual_date;
            $serviceSchedule->is_serviced = $updateServiceScheduleRequest->is_serviced;
            $serviceSchedule->updated_by = Auth::user()->id;

            $serviceSchedule->save();

            return $this->success($serviceSchedule, MyApp::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
