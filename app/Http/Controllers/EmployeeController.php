<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeIndexRequest;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ApiResponser;
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    public function index(EmployeeIndexRequest $request)
    {
        $employees = $this->service->getAllEmployee($request);
        return $this->showPaginate('employees', collect(EmployeeResource::collection($employees)), collect($employees));
    }

    public function store(EmployeeStoreRequest $request)
    {
        $employee = $this->service->createNewEmployee($request);
        return $this->showOne(new EmployeeResource($employee));
    }

    public function show($id)
    {
        $employee = $this->service->getEmployeeById($id);
        return $this->showOne(new EmployeeResource($employee));
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        $status = $this->service->updateEmployee($request, $id);
        return $this->showOne($status);
    }

    public function destroy($id)
    {
        $status = $this->service->deleteEmployee($id);
        return $this->showOne($status);
    }
}
