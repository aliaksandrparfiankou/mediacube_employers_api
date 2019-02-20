<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Http\Models\Employee::class, 50)->create()->each(function ($employee) {
            $departmentIds = \App\Http\Models\Department::orderBy(DB::raw('RAND()'))
                ->limit(rand(1, 3))
                ->pluck('id')
                ->toArray();

            $employee->departments()->sync($departmentIds);
        });
    }
}
