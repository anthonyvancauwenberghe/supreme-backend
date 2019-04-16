<?php

use Modules\User\Entities\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'identity_id'    => (new \MongoDB\BSON\ObjectId())->__toString(),
        'name'           => $faker->name,
        'username'       => $faker->userName,
        'email'          => $faker->unique()->safeEmail,
        'email_verified' => $faker->boolean,
        'gender'         => get_random_array_element(['male', 'female', 'unknown']),
        'avatar'         => 'https://i1.wp.com/cdn.auth0.com/avatars/ad.png',
        'provider'       => 'database',
    ];
});
