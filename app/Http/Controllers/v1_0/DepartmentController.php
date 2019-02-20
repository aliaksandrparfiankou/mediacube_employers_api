<?php

namespace App\Http\Controllers\v1_0;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentAddRequest;
use App\Http\Requests\DepartmentEditRequest;
use App\Http\Requests\DepartmentGetRequest;
use App\Http\Requests\DepartmentRemoveRequest;
use App\Http\Requests\DepartmentsGetRequest;
use App\Http\Resources\Department;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @enpoint /department.add
     * @method post
     * @params {
     *     name: string
     * }
     * @response {
     *     id: uint
     * }
     *
     * @param DepartmentAddRequest $request
     * @return Department
     */
    public function add(DepartmentAddRequest $request)
    {
        $department = $this->departmentRepository->add($request->input('name'));

        return new Department($department);
    }

    /**
     * @enpoint /department.remove
     * @method post
     * @params {
     *     id: uint
     * }
     * @errors {
     *     406 - Resource not found
     *     409 - Cannot remove a not empty department
     * }
     * @response empty
     *
     * @param DepartmentRemoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Http\ResourceNotFoundHttpException
     * @throws \App\Exceptions\Http\RejectedHttpException
     */
    public function remove(DepartmentRemoveRequest $request)
    {
        $this->departmentRepository->remove($request->input('id'));

        return $this->jsonSuccessfulResponse();
    }

    /**
     * @enpoint /department.edit
     * @method post
     * @params {
     *     id: uint
     *     name: string
     * }
     * @errors {
     *     406 - Resource not found
     * }
     * @response empty
     *
     * @param DepartmentEditRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Http\ResourceNotFoundHttpException
     */
    public function edit(DepartmentEditRequest $request)
    {
        $this->departmentRepository->edit(
            $request->input('id'),
            $request->input('name')
        );

        return $this->jsonSuccessfulResponse();
    }

    /**
     * @enpoint /department.get
     * @method get
     * @params {
     *     id: uint
     * }
     * @errors {
     *     406 - Resource not found
     * }
     * @response {
     *     id: uint
     *     name: uint
     *     employees_count: uint
     *     max_salary: uint (optional)
     * }
     *
     * @param DepartmentGetRequest $request
     * @return Department
     * @throws \App\Exceptions\Http\ResourceNotFoundHttpException
     */
    public function get(DepartmentGetRequest $request)
    {
        $department = $this->departmentRepository->get($request->input('id'));

        return new Department($department);
    }

    /**
     * @enpoint /departments.get
     * @method get
     * @params {
     *     count: uint (optional)
     *     page_number: uint (optional)
     * }
     * @response array of {
     *     id: uint
     *     name: uint
     *     employees_count: uint
     *     max_salary: uint (optional)
     * }
     *
     * @param DepartmentsGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginate(DepartmentsGetRequest $request)
    {
        $count = $request->input('count', 15);
        $pageNumber = $request->input('page_number', 1);
        $departments = $this->departmentRepository->paginate($count, $pageNumber);

        return Department::collection($departments);
    }
}
