<?php

use Faker\Generator as Faker;
use Modules\Shipping\Entities\Shipping;

$factory->define(Shipping::class, function (Faker $faker) {
    return [
        "full_name" => $faker->name,
        "email" => $faker->email,
        "telephone" => $faker->phoneNumber,
        "address" => $faker->address,
        "address_2" => "",
        "address_3" => "",
        "city" => $faker->city,
        "postal_code" => $faker->postcode,
        "country" => $faker->country
    ];
});
