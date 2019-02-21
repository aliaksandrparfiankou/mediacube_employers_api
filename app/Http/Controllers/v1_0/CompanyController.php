<?php

namespace App\Http\Controllers\v1_0;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CompanyRepository;
use App\Http\Requests\CompanyGetEmployeesRequest;
use App\Http\Resources\DepartmentSimplified;
use App\Http\Resources\EmployeeSimplified;

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
     *     page_number: uint (optional)
     * }
     * @response {
     *     employees: array of {
     *         id: uint
     *         name: uint
     *         employees_count: uint
     *         max_salary: uint (optional)
     *     },
     *     employees_count: uint,
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
        $pageNumber = $request->input('page_number', 1);
        $employees = $this->companyRepository->getEmployees($count, $pageNumber);

        return response()->json([
            'employees' => EmployeeSimplified::collection($employees),
            'employees_count' => \App\Http\Models\Employee::count(),
            'departments' => DepartmentSimplified::collection(\App\Http\Models\Department::all())
        ]);
    }
}
