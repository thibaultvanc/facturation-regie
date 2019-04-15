<?php

use Faker\Generator as Faker;
use FacturationRegie\Tests\Stubs\Models\Task;
use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\Tests\Stubs\Models\Meeting;
use FacturationRegie\Tests\Stubs\Models\Project;
use FacturationRegie\Pointage;

$factory->define(User::class, function (Faker $faker) {
    $faker = \Faker\Factory::create("fr_FR");

    return [
        "name" => $faker->name,
        "email" => $faker->email,
        "password" => bcrypt('regie'),
    ];
});



$factory->define(Project::class, function (Faker $faker) {
    $faker = \Faker\Factory::create("fr_FR");

    return [
        "name" => $faker->name,
    ];
});



$factory->define(Task::class, function (Faker $faker) {
    $faker = \Faker\Factory::create("fr_FR");

    return [
        "name" => $faker->name,
        "project_id" => factory(Project::class)->create()->id,
        "responsable_id" => factory(User::class)->create()->id,
    ];
});



$factory->define(Meeting::class, function (Faker $faker) {
    $faker = \Faker\Factory::create("fr_FR");

    return [
        "name" => $faker->name,
        "project_id" => factory(Project::class)->create()->id,
        "user_id" => factory(User::class)->create()->id,
    ];
});




$factory->define(Pointage::class, function (Faker $faker) {
    $faker = \Faker\Factory::create("fr_FR");

    $pointableClass = [ Task::class, Meeting::class ][rand(0, 1)];

    $a = Pointage::getUnits();
    $type = $a[rand(0, count($a)-1)];
    return [
        "date" => now(),
        "user_id" => factory(User::class)->create()->id,
        "pointable_id" => factory(Task::class)->create()->id,
        "pointable_type" => $pointableClass,
        "name" => $faker->name,
        "description" => $faker->sentence,

        "units"=> rand(0, 100),
        "unit_type"=> $type
    ];
});
