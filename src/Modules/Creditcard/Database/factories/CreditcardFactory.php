<?php

use Faker\Generator as Faker;
use Modules\Creditcard\Entities\Creditcard;

$factory->define(Creditcard::class, function (Faker $faker) {
    return [
        "type" => $type = $faker->randomElement(["american_express", "visa", "master"]),
        "number" => $faker->creditCardNumber(),
        "expiry_month" => $faker->numberBetween(1,12),
        "expiry_year" => $faker->numberBetween(2020,2025),
        "cvv" => strval($faker->numberBetween(100,9999)),
    ];
});
