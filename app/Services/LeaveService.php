<?php

namespace App\Services;

use App\Models\Leave;
use App\Traits\AdminInfo;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LeaveService
{
    use AdminInfo;

    public function getAllLeave($request)
    {
        return Leave::when($request->employee_id, function ($query) use ($request) {
            $query->where('employee_id', $request->employee_id);
        })
            ->paginate($request->input('page_size', 10));
    }
    public function createNewEmployeeLeave($request)
    {
        $data = $request->only('employee_id', 'reason', 'start_date', 'end_date');
        $countLeave =  $this->countCurrentLeave($request['employee_id'], $request['start_date'], $request['end_date']);

        if ($countLeave >= Leave::MAX_YEAR_LEAVE) {
            throw new HttpException(422, 'Max 5 leave(s) in one year!');
        }
        $data['admin_id'] = $this->getCurrentAdmin()->id;
        return Leave::create($data);
    }

    public function getLeaveById($id)
    {
        return Leave::findOrFail($id);
    }

    public function updateLeaveById($request, $id)
    {
        $leave = $this->getLeaveById($id);
        $data = $request->only('reason', 'start_date', 'end_date');
        $countLeave =  $this->countCurrentLeave($leave->employee_id, $request['start_date'], $request['end_date']);

        if ($countLeave >= Leave::MAX_YEAR_LEAVE) {
            throw new HttpException(422, 'Max 5 leave(s) in one year!');
        }

        return $leave->update($data);
    }

    public function countCurrentLeave($employeeId, $startYear, $endYear)
    {
        return Leave::where('employee_id', $employeeId)
            ->where(function ($query) use ($startYear, $endYear) {
                $query->whereYear('start_date', $startYear)
                    ->orWhereYear('end_date', $startYear)
                    ->orWhereYear('start_date', $endYear)
                    ->orWhereYear('end_date', $endYear);
            })->count();
    }

    public function deleteLeaveById($id)
    {
        $leave = $this->getLeaveById($id);
        return $leave->delete();
    }
}
