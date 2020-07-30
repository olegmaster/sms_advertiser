<?php

use Illuminate\Database\Seeder;

class MmsMediaFilesTableSeeder extends Seeder
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
        for ($i = 0; $i < config('seed.mmsMediaFilesCount'); $i++) {
            $items[] = [
                'file_path' => $faker->url,
                'mms_media_files_groups_id' => rand(1, config('seed.mmsMediaFilesGroupsCount')),
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            ];
        }

        \Illuminate\Support\Facades\DB::table('mms_media_files')->insert($items);

    }
}
