<?php

use Illuminate\Database\Seeder;

class ProxiesSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.proxiesCount'); $i++) {
            $items[] = [
                'type' => rand(0, 2),
                'ip' => rand(100, 250) . '.' . rand(100, 250) . '.' . rand(100, 250) . '.' . rand(100, 250),
                'port' => rand(1024, 65000),
                'login' => $faker->word,
                'password' => $faker->word,
                'status' => rand(0, 1),
                'busy_by_task_id' => rand(0, 1000),
                'last_used_on' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'is_banned' => rand(0, 1),
                'last_checked_on' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'last_checked_status' => $faker->word,
                'check_state' => rand(0,2),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }
        DB::table('proxies')->insert($items);

    }
}
