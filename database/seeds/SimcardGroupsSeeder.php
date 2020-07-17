<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimcardGroupsSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.simcardGroupsCount'); $i++) {
            $items[] = [
                'name' => $faker->word,
                'all_clicks_count' => rand(1000, 5000),
                'all_sent_sms_count' => rand(1000, 5000),
                'all_sent_voice_call_count' => rand(1000, 5000),
                'is_used_on_spam' => rand(0, 1),
                'status' => rand(0, 1),
                'countries_id' => rand(1, config('seed.countriesCount')),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }
        DB::table('simcard_groups')->insert($items);
    }
}
