<?php

use Illuminate\Database\Seeder;

class MmsMediaFilesGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [];
        for ($i = 0; $i < config('seed.mmsMediaFilesGroupsCount'); $i++) {
            $items[] = [
                'id' => $i+1
            ];
        }

        \Illuminate\Support\Facades\DB::table('mms_media_files_groups')->insert($items);

    }
}
