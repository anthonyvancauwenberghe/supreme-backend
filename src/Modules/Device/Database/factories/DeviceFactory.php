<?php

use Faker\Generator as Faker;
use Modules\Device\Entities\Device;

$factory->define(Device::class, function (Faker $faker) {
    return [
        "device_id" => $faker->uuid,
        'device_type' => $faker->randomElement(['ANDROID','IOS','DESKTOP']),
        'notify_restock' => $faker->boolean,
        'notify_wishlist' => $faker->boolean,
        'notify_drop' => $faker->boolean
    ];
});
