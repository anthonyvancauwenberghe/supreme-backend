<?php

use Faker\Generator as Faker;
use Modules\Order\Entities\Order;

$factory->define(Order::class, function (Faker $faker) {
    return [
        "item_id" => $faker->randomNumber(),
        "style_id" => $faker->randomNumber(),
        "size_id" => $faker->randomNumber(),
        "mobile_api" => $faker->boolean,
        "recaptcha_bypass" => $faker->boolean,
        "checkout_delay" => $faker->randomFloat(1,0,20),
        "status" => $faker->randomElement(['SUCCESS','ROBOT','FAILED'])
    ];
});
