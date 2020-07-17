<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimbankSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.simbanksCount'); $i++) {
            $items[] = [
                'name' => $faker->word,
                'capacity' => rand(config('seed.simbankCapasityMin'), config('seed.simbankCapasityMax')),
                'all_sent_sms_count' => rand(1000, 5000),
                'all_sent_mms_count' => rand(1000, 5000),
                'all_sent_voice_call_count' => rand(1000, 5000),
                'status' => rand(0, 1),
                'countries_id' => rand(1, config('seed.countriesCount')),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }
        DB::table('simbanks')->insert($items);
    }
}
