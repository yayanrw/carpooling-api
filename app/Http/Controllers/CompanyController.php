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

    public function show(Company $company)
    {
        try {
            return $this->success($company);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CompanyRequest $companyRequest, Company $company)
    {
        try {
            $company->company_name = $companyRequest->company_name;
            $company->updated_by = Auth::user()->id;

            $company->save();

            return $this->success($company, MyApp::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Company $company)
    {
        try {
            $company->deleted_by = Auth::user()->id;
            $company->save();
            $company->delete();

            return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
