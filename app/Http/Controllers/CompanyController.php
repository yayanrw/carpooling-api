<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $company = Company::withoutTrashed()->get();
            return $this->success($company);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCompanyRequest $storeCompanyRequest)
    {
        try {
            $storeCompanyRequest->validated($storeCompanyRequest->all());

            $company = Company::create([
                'company_name' => $storeCompanyRequest->company_name,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($company, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        try {
            $company = Company::find($id);

            if (!empty($company)) {
                return $this->success($company);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateCompanyRequest $updateCompanyRequest, int $id)
    {
        try {
            $company = Company::find($id);

            if (!empty($company)) {
                $company->company_name = $updateCompanyRequest->company_name;
                $company->updated_by = Auth::user()->id;

                $company->save();

                return $this->success($company, MyApp::UPDATED_SUCCESSFULLY);
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
            $company = Company::find($id);

            if (!empty($company)) {
                $company->deleted_by = Auth::user()->id;
                $company->save();
                $company->delete();

                return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
