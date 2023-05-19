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
                'company_id' => $officeRequest->company_name,
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

    public function show(int $id)
    {
        try {
            $office = Office::find($id);

            if (!empty($office)) {
                return $this->success($office);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(OfficeRequest $officeRequest, int $id)
    {
        try {
            $office = Office::find($id);

            if (!empty($office)) {
                $office->company_id = $officeRequest->company_id;
                $office->office_name = $officeRequest->office_name;
                $office->region = $officeRequest->region;
                $office->type = $officeRequest->type;
                $office->updated_by = Auth::user()->id;

                $office->save();

                return $this->success($office, MyApp::UPDATED_SUCCESSFULLY);
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
            $office = Office::find($id);

            if (!empty($office)) {
                $office->deleted_by = Auth::user()->id;
                $office->save();
                $office->delete();

                return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
