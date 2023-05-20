<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeRequest;
use App\Models\Office;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('ability:super_admin,admin')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        try {
            $office = Office::withoutTrashed()->get();
            return $this->success($office);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(OfficeRequest $officeRequest)
    {
        try {
            $officeRequest->validated($officeRequest->all());

            $office = Office::create([
                'company_id' => $officeRequest->company_id,
                'office_name' => $officeRequest->office_name,
                'region' => $officeRequest->region,
                'type' => $officeRequest->type,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($office, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Office $office)
    {
        try {
            return $this->success($office);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(OfficeRequest $officeRequest, Office $office)
    {
        try {
            $office->company_id = $officeRequest->company_id;
            $office->office_name = $officeRequest->office_name;
            $office->region = $officeRequest->region;
            $office->type = $officeRequest->type;
            $office->updated_by = Auth::user()->id;

            $office->save();

            return $this->success($office, MyApp::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Office $office)
    {
        try {
            $office->deleted_by = Auth::user()->id;
            $office->save();
            $office->delete();

            return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
