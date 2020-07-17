<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $items = [];
        $tarifEndTime = \Illuminate\Support\Carbon::now()->addDays(200);
        for ($i = 0; $i < config('seed.simcardsCount'); $i++) {
            $items[] = [
                'number' => $faker->randomNumber(9),
                'status' => rand(0, 1),
                'tarif_end_time' => $tarifEndTime->toDateTimeString(),
                'is_registered' => rand(0, 1),
                'register_date' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'balance' => rand(45, 200),
                'is_used_on_spam' => rand(0, 1),
                'last_used' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'is_banned' => rand(0, 1),
                'simcard_group_id' => rand(1, config('seed.simcardGroupsCount')),
                'simcard_operator_id' => rand(1, config('seed.simcardOperatorsCount')),
                'simbank_id' => rand(1, config('seed.simbanksCount')),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }

        // TODO
        // delete simcards that overwhelms a simbank capacity

        \Illuminate\Support\Facades\DB::table('simcards')->insert($items);
    }
}
