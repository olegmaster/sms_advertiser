<?php

namespace App\Models\AdvertisingCampaign;

use Illuminate\Database\Eloquent\Model;

class Simbank extends Model
{
    public const ACTIVATE_ACTION = 1;
    public const DEACTIVATE_ACTION = 2;
    public const UPDATE_SIMBANK_DATA_ACTION = 3;

    public const ACTIVE_STATUS = 1;
    public const INACTIVE_STATUS = 0;




}
