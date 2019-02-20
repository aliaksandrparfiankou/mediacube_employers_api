<?php

namespace App\Http\Repositories;

use App\Http\Models\Employee;

class CompanyRepository extends Repository
{
    public function getEmployees(int $count, int $pageNumber = 1)
    {
        $query = Employee::query();

        if ($pageNumber > 1) {
            $query->skip(($pageNumber - 1) * $count);
        }

        return $query->limit($count)->get();
    }
}
