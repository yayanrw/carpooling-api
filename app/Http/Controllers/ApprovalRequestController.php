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

    public function show(int $id)
    {
        try {
            $approvalRequest = ApprovalRequest::find($id);

            if (!empty($approvalRequest)) {
                return $this->success($approvalRequest);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateApprovalRequest $updateApprovalRequest, int $id)
    {
        try {
            $approvalRequest = ApprovalRequest::find($id);

            if (!empty($approvalRequest)) {
                $approvalRequest->note = $updateApprovalRequest->note;
                $approvalRequest->is_approved = $updateApprovalRequest->is_approved;
                $approvalRequest->approved_at = date('Y-m-d H:i:s');

                $approvalRequest->save();

                return $this->success($approvalRequest, MyApp::UPDATED_SUCCESSFULLY);
            } else {
                return $this->error(null, MyApp::DATA_NOT_FOUND, MyApp::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
