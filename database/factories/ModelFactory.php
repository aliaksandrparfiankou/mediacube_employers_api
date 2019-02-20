<?php

use App\Http\Enums\GenderEnum;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Http\Models\Employee::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->randomElement([
            null,
            $faker->firstName
        ]),
        'gender' => $faker->randomElement([
            null,
            GenderEnum::MALE,
            GenderEnum::FEMALE,
            GenderEnum::TRANSGENDER,
        ]),
        'salary' => $faker->randomElement([
            null,
            ceil($faker->randomNumber(4) / 100) * 100
        ]),
    ];
});

$factory->define(App\Http\Models\Department::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company,
    ];
});
