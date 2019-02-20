<?php

namespace App\Http\Repositories;

use App\Exceptions\Http\RejectedHttpException;
use App\Exceptions\Http\ResourceNotFoundHttpException;
use App\Http\Models\Department;

class DepartmentRepository extends Repository
{
    public function add(string $name)
    {
        $department = new Department();

        return $department->create([
            'name' => $name,
        ]);
    }

    public function remove(int $id)
    {
        $department = Department::find($id);

        if (is_null($department)) {
            throw new ResourceNotFoundHttpException();
        }

        if ($department->employees()->count()) {
            throw new RejectedHttpException();
        }

        Department::destroy($id);
    }

    public function edit(int $id, string $name)
    {
        $department = Department::find($id);

        if (is_null($department)) {
            throw new ResourceNotFoundHttpException();
        }

        $department->name = $name;
        $department->save();
    }

    public function get(int $id)
    {
        $department = Department::find($id);

        if (is_null($department)) {
            throw new ResourceNotFoundHttpException();
        }

        return $department;
    }

    public function paginate(int $count, int $pageNumber = 1)
    {
        $query = Department::query();

        if ($pageNumber > 1) {
            $query->skip(($pageNumber - 1) * $count);
        }

        return $query->limit($count)->get();
    }
}
