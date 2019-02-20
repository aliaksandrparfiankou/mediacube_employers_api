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

$router->get('/', function () use ($router) {
    $employee = \App\Http\Models\Employee::first();

    return response()->json([
        'id' => $employee->id,
        'first_name' => $employee->first_name,
        'departments' => $employee->departments->pluck('name')
    ]);
});
