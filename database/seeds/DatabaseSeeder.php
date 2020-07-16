<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(CitySeeder::class);
//        factory(\App\Models\AdvertisingCampaign\Simcard::class, 100)->create();
//        factory(\App\Models\DomainsRedirects\Domain::class, 50)->create();
    }
}
