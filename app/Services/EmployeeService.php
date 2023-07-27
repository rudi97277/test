<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{

    public function getAllEmployee($request)
    {
        return Employee::when($request->include, function ($query) {
            $query->with('leave');
        })->paginate($request->input('page_size', 10));
    }

    public function createNewEmployee($request)
    {
        $data = $request->only('first_name', 'last_name', 'email', 'phone_number', 'address', 'gender');
        return Employee::create($data);
    }

    public function updateEmployee($request, $id)
    {
        $employee = $this->getEmployeeById($id);
        $data = $request->only('first_name', 'last_name', 'email', 'phone_number', 'address', 'gender');
        return $employee->update($data);
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function deleteEmployee($id)
    {
        $employee = $this->getEmployeeById($id);
        return $employee->delete();
    }
}
