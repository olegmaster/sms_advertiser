<?php

use Illuminate\Database\Seeder;

class SimcardOperatorSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.simcardOperatorsCount'); $i++) {
            $items[] = [
                'name' => $faker->word,
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }
        \Illuminate\Support\Facades\DB::table('simcard_operators')->insert($items);
    }
}
