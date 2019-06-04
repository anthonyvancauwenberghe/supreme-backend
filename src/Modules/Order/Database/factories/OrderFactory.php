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
        "checkout_delay" => $delay = $faker->numberBetween(0,10000),
        "atc_duration" => $atc = $faker->numberBetween(0,3000),
        "checkout_load_duration" => $loading = $faker->numberBetween(0,3000),
        "checkout_fill_duration" => $filling = $delay + $faker->numberBetween(0,2000),
        "checkout_response_duration" => $checkingOutResponse = $faker->numberBetween(0,3000),
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
