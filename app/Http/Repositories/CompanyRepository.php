<?php

namespace App\Http\Repositories;

use App\Http\Models\Employee;

class CompanyRepository extends Repository
{
    public function getEmployees(int $count, int $lastId = null)
    {
        $query = Employee::query();

        if (!is_null($lastId)) {
            $query->where('id', '>', $lastId);
        }

        return $query->limit($count)->get();
    }
}
