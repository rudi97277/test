<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveStoreRequest;
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

    public function index()
    {
        //
    }

    public function store(LeaveStoreRequest $request)
    {
        $leave = $this->service->createNewEmployeeLeave($request);
        return $this->showOne(new LeaveResource($leave));
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
