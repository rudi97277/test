<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'reason',
        'start_date',
        'end_date',
        'admin_id'
    ];

    public const MAX_YEAR_LEAVE = 5;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
