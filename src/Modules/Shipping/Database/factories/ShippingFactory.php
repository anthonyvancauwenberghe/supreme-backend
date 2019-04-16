<?php

use Faker\Generator as Faker;
use Modules\Shipping\Entities\Shipping;

$factory->define(Shipping::class, function (Faker $faker) {
    return [
        "full_name" => "John Appleseed",
        "email" => "john.apple@mail.com",
        "telephone" => "0123456789",
        "address" => "3318 Jarvis Street3318 Jarvis Street3318 Jarvis Street",
        "address_2" => "",
        "address_3" => "",
        "city" => "New York",
        "postal_code" => "14171",
        "country" => "United States of America"
    ];
});
