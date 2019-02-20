<?php

namespace App\Http\Controllers\v1_0;

use App\Http\Controllers\Controller;
use App\Http\Repositories\EmployeeRepository;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeEditRequest;
use App\Http\Requests\EmployeeGetRequest;
use App\Http\Requests\EmployeeRemoveRequest;
use App\Http\Requests\EmployeesGetRequest;
use App\Http\Resources\Employee;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @enpoint /employee.add
     * @method post
     * @params {
     *     first_name: string
     *     last_name: string
     *     middle_name: string (optional)
     *     gender: {ENUM} GenderEnum (optional),
     *     salary: uint (optional),
     *     department_ids: uint[]
     * }
     * @GenderEnum {
     *     MALE = 1
     *     FEMALE = 2
     *     TRANSGENDER = 3
     * }
     * @response {
     *     id: uint
     * }
     * @errors {
     *     409 - One or several department ids refer to non-existant department
     * }
     *
     * @param EmployeeAddRequest $request
     * @return Employee
     * @throws \App\Exceptions\Http\RejectedHttpException
     */
    public function add(EmployeeAddRequest $request)
    {
        $employee = $this->employeeRepository->add(
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('middle_name'),
            $request->input('gender'),
            $request->input('salary'),
            $request->input('department_ids')
        );

        return new Employee($employee);
    }

    /**
     * @enpoint /employee.remove
     * @method post
     * @params {
     *     id: uint
     * }
     * @response empty
     * @errors {
     *     406 - Id refer to non-existant employee
     * }
     *
     * @param EmployeeRemoveRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\Http\ResourceNotFoundHttpException
     */
    public function remove(EmployeeRemoveRequest $request)
    {
        $this->employeeRepository->remove($request->input('id'));

        return $this->jsonSuccessfulResponse();
    }

    /**
     * @enpoint /employee.add
     * @method post
     * @params {
     *     first_name: string
     *     last_name: string
     *     middle_name: string (optional)
     *     gender: {ENUM} GenderEnum (optional),
     *     salary: uint (optional),
     *     department_ids: uint[]
     * }
     * @GenderEnum {
     *     MALE = 1
     *     FEMALE = 2
     *     TRANSGENDER = 3
     * }
     * @response {
     *     id: uint
     * }
     * @errors {
     *     406 - Employee id refer to non-existant employee
     *     409 - One or several department ids refer to non-existant department
     * }
     *
     * @param EmployeeEditRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\Http\ResourceNotFoundHttpException
     * @throws \App\Exceptions\Http\RejectedHttpException
     */
    public function edit(EmployeeEditRequest $request)
    {
        $this->employeeRepository->edit(
            $request->input('id'),
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('middle_name'),
            $request->input('gender'),
            $request->input('salary'),
            $request->input('department_ids')
        );

        return $this->jsonSuccessfulResponse();
    }

    /**
     * @enpoint /employee.get
     * @method get
     * @params {
     *     id: uint
     * }
     * @response {
     *     id: uint
     *     first_name: string
     *     last_name: string
     *     middle_name: string (optional)
     *     gender: {ENUM} GenderEnum (optional),
     *     salary: uint (optional),
     *     department_ids: uint[]
     * }
     * @GenderEnum {
     *     MALE = 1
     *     FEMALE = 2
     *     TRANSGENDER = 3
     * }
     * @errors {
     *     406 - Employee id refer to non-existant employee
     * }
     *
     * @param EmployeeGetRequest $request
     * @return Employee
     * @throws \App\Exceptions\Http\ResourceNotFoundHttpException
     */
    public function get(EmployeeGetRequest $request)
    {
        $employee = $this->employeeRepository->get(
            $request->input('id')
        );

        return new Employee($employee);
    }

    /**
     * @enpoint /employees.get
     * @method get
     * @params {
     *     page_number: uint (optional)
     *     count: uint (optional)
     * }
     * @response array of {
     *     id: uint
     *     first_name: string
     *     last_name: string
     *     middle_name: string (optional)
     *     gender: {ENUM} GenderEnum (optional),
     *     salary: uint (optional),
     *     department_ids: uint[]
     * }
     * @GenderEnum {
     *     MALE = 1
     *     FEMALE = 2
     *     TRANSGENDER = 3
     * }
     * @errors {
     *     406 - Employee id refer to non-existant employee
     * }
     *
     * @param EmployeesGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginate(EmployeesGetRequest $request)
    {
        $count = $request->input('count', 15);
        $pageNumber = $request->input('page_number', 1);
        $employees = $this->employeeRepository->paginate($count, $pageNumber);

        return Employee::collection($employees);
    }
}
