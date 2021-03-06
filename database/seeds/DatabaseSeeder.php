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
        // Locations seeding
        $this->call(CountrySeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(CitySeeder::class);

        // Users seeding
        $this->call(PermissionsSeeder::class);

        // related with simcards
        $this->call(SimbankSeeder::class);
        $this->call(SimcardGroupsSeeder::class);
        $this->call(SimcardOperatorSeeder::class);
        $this->call(SimcardSeeder::class);

        // add company
        $this->call(ThematicsSeeder::class);
        $this->call(AdvertisingCampaignSeeder::class);

        //Targeting
        $this->call(BoardsTableSeeder::class);

        //Proxies
        $this->call(ProxiesSeeder::class);
        $this->call(ProxyCheckingStatesTableSeeder::class);

        // settings
        $this->call(RedirectDomainSeeder::class);


        //factory(\App\Models\User::class, 15)->create();

//        factory(\App\Models\AdvertisingCampaign\Simcard::class, 100)->create();
//        factory(\App\Models\DomainsRedirects\Domain::class, 50)->create();

        //Messages
        $this->call(SmsMmsMessagesTableSeeder::class);
        $this->call(MmsMediaFilesGroupsTableSeeder::class);
        $this->call(MmsMediaFilesTableSeeder::class);
        $this->call(VoiceMessageSeeder::class);



    }
}
