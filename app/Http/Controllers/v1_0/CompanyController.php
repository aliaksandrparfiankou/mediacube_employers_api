<?php

namespace App\Http\Controllers\v1_0;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CompanyRepository;
use App\Http\Requests\CompanyGetEmployeesRequest;
use App\Http\Resources\DepartmentSimplified;
use App\Http\Resources\Employee;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @enpoint /company.getEmployees
     * @method get
     * @params {
     *     count: uint (optional)
     *     last_id: uint (optional)
     * }
     * @response {
     *     employees: array of {
     *         id: uint
     *         name: uint
     *         employees_count: uint
     *         max_salary: uint (optional)
     *     },
     *     departments: array of {
     *         id: uint
     *         name: string
     *     }
     * }
     *
     * @param CompanyGetEmployeesRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getEmployees(CompanyGetEmployeesRequest $request)
    {
        $count = $request->input('count', 15);
        $lastId = $request->input('last_id');
        $employees = $this->companyRepository->getEmployees($count, $lastId);

        return response()->json([
            'employees' => Employee::collection($employees),
            'departments' => DepartmentSimplified::collection(\App\Http\Models\Department::all())
        ]);
    }
}
