<?php

use Illuminate\Database\Seeder;

class AdvertisingCampaignSeeder extends Seeder
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
        $endDate = \Illuminate\Support\Carbon::now()->addDays(200);
        for ($i = 0; $i < config('seed.advertisingCampaignsCount'); $i++) {
            $items[] = [
                'name' => 'Ad comp ' . $faker->word,
                'thematics_id' => rand(1, config('seed.thematicsCount')),
                'source_type' => rand(1, 4),
                'source_id' => rand(1, 300),
                'simcard_group_id' => rand(1, config('seed.simcardGroupsCount')),
                'creator_user_id' => rand(1, config('seed.usersCount')),
                'comment' => $faker->text,
                'state' => rand(1, 3),
                'stop_comment' => $faker->text,
                'is_deleted' => 0,
                'is_archived' => 0,
                'start_date' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'finish_date' => $endDate->toDateTimeString(),
                'send_sms_mms' => rand(0, 1),
                'send_voice' => rand(0, 1),
                'auto_answer' => rand(0, 1),
                'send_sms_voice_priority' => rand(1, 5),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }

        \Illuminate\Support\Facades\DB::table('advertising_campaign_tasks')->insert($items);

    }
}
