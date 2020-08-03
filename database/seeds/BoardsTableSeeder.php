<?php

use Illuminate\Database\Seeder;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $items = [];

        //Парсер olx.pl
        $items[] = [
            'name' => 'olx.pl',
            'uid_name' => 'olx_pl',
            'filter_table_name' => 'boards_filters_olx_pl',
            'offers_table_name' => 'boards_offers_olx_pl',
            'status' => 1,
            'checking_state' => 0,
            'last_check_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'last_check_status' => '',
            'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
        ];

        //Парсер otomoto.pl
        $items[] = [
            'name' => 'otomoto.pl',
            'uid_name' => 'otomoto_pl',
            'filter_table_name' => 'boards_filters_otomoto_pl',
            'offers_table_name' => 'boards_offers_otomoto_pl',
            'status' => 1,
            'checking_state' => 0,
            'last_check_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'last_check_status' => '',
            'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
        ];


        DB::table('boards')->insert($items);



    }
}
