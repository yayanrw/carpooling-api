<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use App\Models\ApprovalRequest;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;

class ApprovalRequestController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('ability:super_admin,admin')->only(['store', 'update']);
        $this->middleware('ability:admin')->only(['store']);
        $this->middleware('ability:approver')->only(['update']);
    }

    public function index()
    {
        try {
            $approvalRequest = ApprovalRequest::withoutTrashed()->get();
            return $this->success($approvalRequest);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreApprovalRequest $storeApprovalRequest)
    {
        try {
            $storeApprovalRequest->validated($storeApprovalRequest->all());

            $approvalRequest = ApprovalRequest::create([
                'vehicle_booking_id' => $storeApprovalRequest->vehicle_booking_id,
                'approval_user_id' => $storeApprovalRequest->approval_user_id,
                'approval_order' => $storeApprovalRequest->approval_order,
            ]);

            return $this->success($approvalRequest, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(ApprovalRequest $approvalRequest)
    {
        try {
            return $this->success($approvalRequest);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateApprovalRequest $updateApprovalRequest, ApprovalRequest $approvalRequest)
    {
        try {
            $approvalRequest->note = $updateApprovalRequest->note;
            $approvalRequest->is_approved = $updateApprovalRequest->is_approved;
            $approvalRequest->approved_at = date('Y-m-d H:i:s');

            $approvalRequest->save();

            return $this->success($approvalRequest, MyApp::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
