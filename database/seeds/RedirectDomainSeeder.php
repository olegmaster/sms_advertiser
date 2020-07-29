<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RedirectDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $domains = [];
        $domainDateStat = [];
        $domainSettings = [];
        for ($i = 0; $i < config('seed.domainsCount'); $i++) {
            $domains[] = [
                'domain' => $faker->url,
                'is_banned' => rand(0, 10) == 1 ? 0 : 1,
                'status' => rand(0, 1),
                'is_frozen' => rand(0, 10) == 1 ? 0 : 1,
                'frozen_on' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'freeze_hours' => rand(1, 10),
                'spam_limit' => rand(30000, 50000),
                'current_send_count' => rand(0, 20000),
                'all_send_count' => rand(0, 20000),
                'deleted_at' => rand(0, 100) == 1 ? \Illuminate\Support\Carbon::now()->toDateTimeString() : null,
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];

            for($j = 0; $j < 30; $j++){
                $date = \Illuminate\Support\Carbon::now()->subDays($j);
                $domainDateStat[] = [
                    'domain_id' => $i + 1,
                    'date' => $date->toDateTimeString(),
                    'day' => $date->dayOfWeek,
                    'week' => $date->weekOfYear,
                    'month' => $date->month,
                    'year' => $date->year,
                    'sent_count' => rand(0, 40000),
                    'created_at' => $date->toDateTimeString(),
                    'updated_at' => $date->toDateTimeString(),
                ];
            }

        }

        $domainSettings[] = [
            'work_type' => rand(0,1),
            'unfreeze' => 0,
            'unfreeze_hours' => rand(20, 50)
        ];

        DB::table('domains')->insert($domains);
        DB::table('domain_settings')->insert($domainSettings);
        DB::table('domains_stat_by_dates')->insert($domainDateStat);
    }
}
