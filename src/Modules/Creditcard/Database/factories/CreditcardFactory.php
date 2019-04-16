<?php

use Faker\Generator as Faker;
use Modules\Creditcard\Entities\Creditcard;

$factory->define(Creditcard::class, function (Faker $faker) {
    return [
        "type" => $type = $faker->creditCardType,
        "number" => $faker->creditCardNumber($type),
        "expiry_month" => $faker->numberBetween(1,12),
        "expiry_year" => $faker->numberBetween(2020,2025),
        "cvv" => $faker->numberBetween(0,999),
        "full_name" => $faker->name,
        "address" => $faker->address,
        "address_2" => "",
        "address_3" => "",
        "city" => $faker->city,
        "postal_code" => $faker->postcode,
        "country" => $faker->country
    ];
});
