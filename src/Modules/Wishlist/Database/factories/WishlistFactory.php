<?php

use Faker\Generator as Faker;
use Modules\Wishlist\Entities\Wishlist;

$factory->define(Wishlist::class, function (Faker $faker) {
    return [
        "item_id" => $faker->numberBetween(10000,100000),
        "style_id" => $faker->numberBetween(10000,100000),
        "size_id" => $faker->numberBetween(10000,100000),
        "notify" => $faker->boolean
    ];
});
