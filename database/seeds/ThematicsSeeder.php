<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThematicsSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.thematicsSeedCount'); $i++) {
            $items[] = [
                'name' => $faker->word,
                'status' => rand(0, 1),
                'user_id' => rand(1, 20),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }
        DB::table('thematics')->insert($items);
    }
}
