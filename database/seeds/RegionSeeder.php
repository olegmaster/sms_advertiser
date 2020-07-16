<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $regions = [];
        for ($i = 0; $i < 20; $i++) {
            $regions[] = [
                'name' => $faker->state,
                'country_id' => rand(1, 3),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }
        DB::table('regions')->insert($regions);

    }
}
