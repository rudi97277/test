<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveIndexRequest;
use App\Http\Requests\LeaveStoreRequest;
use App\Http\Requests\LeaveUpdateRequest;
use App\Http\Resources\LeaveResource;
use App\Models\Leave;
use App\Services\LeaveService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    use ApiResponser;
    protected $service;

    public function __construct(LeaveService $service)
    {
        $this->service = $service;
    }

    public function index(LeaveIndexRequest $request)
    {
        $leaves = $this->service->getAllLeave($request);
        return $this->showPaginate('leaves', collect(LeaveResource::collection($leaves)), collect($leaves));
    }

    public function store(LeaveStoreRequest $request)
    {
        $leave = $this->service->createNewEmployeeLeave($request);
        return $this->showOne(new LeaveResource($leave));
    }

    public function show($id)
    {
        $leave = $this->service->getLeaveById($id);
        return $this->showOne(new LeaveResource($leave));
    }

    public function update(LeaveUpdateRequest $request, $id)
    {
        $status = $this->service->updateLeaveById($request, $id);
        return $this->showOne($status);
    }

    public function destroy($id)
    {
        $status = $this->service->deleteLeaveById($id);
        return $this->showOne($status);
    }
}
