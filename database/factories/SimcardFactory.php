<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdvertisingCampaign\Simcard;
use Faker\Generator as Faker;

$factory->define(Simcard::class, function (Faker $faker) {
    return [
        'number' => $faker->randomNumber(9),
        'status' => rand(0, 5) == 2 ? 0 : 1,
        'is_registered' => rand(0, 10) == 2 ? 0 : 1,
        'simcard_group_id' => $faker->randomNumber(1),
        'simcard_operator_id' => rand(1, 3),
        'created_at' => $faker->unixTime(),
        'updated_at' => $faker->unixTime(),
    ];
});
