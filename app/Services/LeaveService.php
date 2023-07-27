<?php

namespace App\Services;

use App\Models\Leave;

class LeaveService
{
    public function createNewEmployeeLeave($request)
    {
        $data = $request->only('employee_id', 'reason', 'start_date', 'end_date');
        return Leave::create($data);
    }
}
