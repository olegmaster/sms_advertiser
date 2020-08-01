<?php

use Illuminate\Database\Seeder;

class VoiceMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [];

        for ($i = 0; $i < config('seed.voiceMessagesCount'); $i++) {
            $items[] = [
                'file_path' => '/media/voice/sample/' . rand(1, 8) . '.mp3',
                'advertising_campaign_tasks_id' => rand(1, config('seed.advertisingCampaignsCount')),
                'sent_count' => rand(10, 100),
                'used_simcards_count' => rand(10, 100),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }

        \Illuminate\Support\Facades\DB::table('voice_messages')->insert($items);

    }
}
