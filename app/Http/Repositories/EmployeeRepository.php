<?php

namespace App\Http\Repositories;

use App\Exceptions\Http\RejectedHttpException;
use App\Exceptions\Http\ResourceNotFoundHttpException;
use App\Http\Models\Department;
use App\Http\Models\Employee;
use App\Http\Models\EmployeeDepartment;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends Repository
{
    public function add(
        string $firstName,
        string $lastName,
        string $middleName = null,
        int $gender = null,
        int $salary = null,
        array $departmentIds = []
    ) {
        $employeeModel = null;

        DB::transaction(function () use (&$employeeModel, $firstName, $lastName, $middleName, $gender, $salary, $departmentIds) {
            $departments = Department::whereIn('id', $departmentIds)->get();

            if ($departments->count() < count($departmentIds)) {
                throw new RejectedHttpException();
            }

            $employee = new Employee();
            $employeeModel = $employee->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'middle_name' => $middleName,
                'gender' => $gender,
                'salary' => $salary,
            ]);
            $employeeModel->departments()->sync($departments);
        });

        return $employeeModel;
    }

    public function edit(
        int $id,
        string $firstName,
        string $lastName,
        string $middleName = null,
        int $gender = null,
        int $salary = null,
        array $departmentIds = []
    ) {
        DB::transaction(function () use ($id, $firstName, $lastName, $middleName, $gender, $salary, $departmentIds) {
            $departments = Department::whereIn('id', $departmentIds)->get();

            if ($departments->count() < count($departmentIds)) {
                throw new RejectedHttpException();
            }

            $employee = Employee::find($id);

            if (is_null($employee)) {
                throw new ResourceNotFoundHttpException();
            }

            $employee->first_name = $firstName;
            $employee->last_name = $lastName;
            $employee->middle_name = $middleName;
            $employee->gender = $gender;
            $employee->salary = $salary;
            $employee->departments()->sync($departments);
            $employee->save();
        });
    }

    public function remove(int $id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            throw new ResourceNotFoundHttpException();
        }

        Employee::destroy($id);
    }

    public function get(int $id) {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            throw new ResourceNotFoundHttpException();
        }

        return $employee;
    }

    public function paginate(int $count, int $pageNumber = 1)
    {
        $query = Employee::query();

        if ($pageNumber > 1) {
            $query->skip(($pageNumber - 1) * $count);
        }

        return $query->limit($count)->get();
    }
}
