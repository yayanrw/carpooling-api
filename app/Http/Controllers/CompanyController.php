<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use HttpResponses;


    public function __construct()
    {
        $this->middleware('ability:super_admin,admin')->only(['store', 'update', 'destroy']);
    }


    public function index()
    {
        try {
            $company = Company::withoutTrashed()->get();
            return $this->success($company);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CompanyRequest $companyRequest)
    {
        try {
            $companyRequest->validated($companyRequest->all());

            $company = Company::create([
                'company_name' => $companyRequest->company_name,
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

    public function update(CompanyRequest $companyRequest, int $id)
    {
        try {
            $company = Company::find($id);

            if (!empty($company)) {
                $company->company_name = $companyRequest->company_name;
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
