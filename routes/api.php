<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

abstract class ApiVersion {
    const v1_0 = 'v1_0';
}

$router->group(['prefix' => ApiVersion::v1_0, 'namespace' => ApiVersion::v1_0], function () use ($router) {
    $router->get('/company.getEmployees', 'CompanyController@getEmployees');

    $router->post('/department.add', 'DepartmentController@add');
    $router->post('/department.remove', 'DepartmentController@remove');
    $router->post('/department.edit', 'DepartmentController@edit');
    $router->get('/department.get', 'DepartmentController@get');
    $router->get('/departments.get', 'DepartmentController@paginate');

    $router->post('/employee.add', 'EmployeeController@add');
    $router->post('/employee.remove', 'EmployeeController@remove');
    $router->post('/employee.edit', 'EmployeeController@edit');
    $router->get('/employee.get', 'EmployeeController@get');
    $router->get('/employees.get', 'EmployeeController@paginate');
});
