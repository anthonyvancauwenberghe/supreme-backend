<?php

use Faker\Generator as Faker;
use Modules\Shipping\Entities\Shipping;

$factory->define(Shipping::class, function (Faker $faker) {
    return [
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "email" => $faker->email,
        "telephone" => $faker->phoneNumber,
        "address" => $faker->address,
        "city" => $faker->city,
        "postal_code" => $faker->postcode,
        "country" => $faker->country,
        "primary" => false,
    ];
});
