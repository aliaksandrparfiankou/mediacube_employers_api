<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'middle_name', 'gender', 'salary'
    ];

    public function departments() {
        return $this->belongsToMany(
            Department::class,
            'employee_departments',
            'employee_id',
            'department_id'
        );
    }
}
