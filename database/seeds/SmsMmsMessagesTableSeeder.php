<?php

use Illuminate\Database\Seeder;

class SmsMmsMessagesTableSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.smsMmsMessagesCount'); $i++) {
            $items[] = [
                'message_type' => rand(0, 1),
                'destination_type' => rand(0, 6),
                'text' => $faker->text,
                'add_link' => $faker->url,
                'include_name' => rand(0, 1),
                'parent_id' => 0,
                'sort_order' => 0,
                'advertising_campaign_task_id' => rand(1, 100),
                'mms_media_files_groups_id' => rand(1, 200),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }

        \Illuminate\Support\Facades\DB::table('sms_mms_messages')->insert($items);

    }
}
