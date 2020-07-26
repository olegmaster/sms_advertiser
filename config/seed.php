<?php

return [
    'countriesCount' => env('SEED_COUNTRIES_COUT', 3),
    'usersCount' => env('SEED_USERS_COUNT', 10),
    'thematicsCount' => env('SEED_THEMATICS_COUNT', 2000),

    // sim
    'simbanksCount' => env('SEED_SIMBANKS_COUNT', 4),
    'simbankCapasityMin' => env('SEED_SIMBANK_CAPASITY_MIN', 150),
    'simbankCapasityMax' => env('SEED_SIMBANK_CAPASITY_MAX', 350),
    'simcardGroupsCount' => env('SEED_SIMCARD_GOUPS_COUNT', 7),
    'simcardOperatorsCount' => env('SEED_SIMCARD_OPERATORS_COUNT', 4),
    'simcardsCount' => env('SEED_SIMCARDS_COUNT', 400),

    // advertising campaigns

    'advertisingCampaignsCount' => env('SEED_ADVERTISING_CAMPAIGNS_COUNT', 5),

    //Settings
    'proxiesCount' => 250,
    'domainsCount' => env('SEED_DOMAINS_COUNT', 100),

];
