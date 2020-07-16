<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DomainsRedirects\Domain;
use Faker\Generator as Faker;

$factory->define(Domain::class, function (Faker $faker) {
    return [
        'domain' => $faker->url,
        'status' => rand(0, 5) == 2 ? 1 : 0,
        'is_registered' => rand(0, 3),
        'is_frozen' => rand(0, 1),
        'freeze_hours' => rand(0, 23),
        'spam_limit' => rand(20000, 30000),
        'current_send_count' => $faker->unixTime(),
        'all_send_count' => rand(20000, 130000),
        'deleted_at' => null,
        'created_at' =>$faker->unixTime(),
        'updated_at' => $faker->unixTime()
    ];
});
