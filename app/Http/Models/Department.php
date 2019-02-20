<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function employees() {
        return $this->belongsToMany(
            Employee::class,
            'employee_departments',
            'department_id',
            'employee_id'
        );
    }
}
