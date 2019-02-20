<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'department_id',
    ];

    public function employee() {
        return $this->hasOne(Employee::class);
    }

    public function department() {
        return $this->hasOne(Department::class);
    }
}
