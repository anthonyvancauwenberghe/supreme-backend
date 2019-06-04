<?php

use Faker\Generator as Faker;
use Modules\Order\Entities\Order;

$factory->define(Order::class, function (Faker $faker) {
    return [
        "item_id" => $faker->randomNumber(),
        "style_id" => $faker->randomNumber(),
        "size_id" => $faker->randomNumber(),
        "mobile_api" => $faker->boolean,
        "region" => "TEST",
        "recaptcha_bypass" => $faker->boolean,
        "checkout_delay" => (float) $delay = $faker->randomFloat(1, 0, 10),
        "atc_duration" => (float) $atc = $faker->randomFloat(2, 0, 3),
        "checkout_load_duration" => (float) $loading = $faker->randomFloat(2, 0, 3),
        "checkout_fill_duration" => (float) $filling = $delay + $faker->randomFloat(1, 0, 2),
        "checkout_response_duration" => (float) $checkingOutResponse = $faker->randomFloat(2, 0, 3),
        'success' => $success = $faker->boolean,
        "status" => $success ? "SUCCESS" : $faker->randomElement(['FAILED_QUEUED', 'FAILED_DETECTED']),
        "error" => $success ? null : "test error",
        "item_name" => "Crinkle Anorak",
        "item_url" => "https://www.supremenewyork.com/shop/jackets/rq4zcojkv/nd25kf96s",
        "item_image" => "https://d17ol771963kd3.cloudfront.net/166869/sw/T7Hai28vTRM.jpg",
        "item_style" => $faker->randomElement(['red', 'blue', 'black']),
        "item_size" => $faker->randomElement(['small', 'medium', 'large'])
    ];
});
