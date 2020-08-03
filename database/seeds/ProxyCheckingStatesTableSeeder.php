<?php

use Illuminate\Database\Seeder;

class ProxyCheckingStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $boardsCount = DB::table('boards')->count();
        $items = [];
        for ($i = 0; $i < config('seed.proxiesCount'); $i++) {
            for ($j = 0; $j < $boardsCount; $j++) {
                $items[] = [
                    'is_banned' => rand(0, 1),
                    'check_state' => 0,
                    'last_checked_on' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                    'last_check_status' => '',
                    'proxy_id' => $i+1,
                    'board_id' => $j+1,
                    'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                ];
            }
        }
        DB::table('proxy_checking_states')->insert($items);

    }
}
