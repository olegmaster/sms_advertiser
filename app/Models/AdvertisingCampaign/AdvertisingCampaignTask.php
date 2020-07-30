<?php

namespace App\Models\AdvertisingCampaign;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class AdvertisingCampaignTask extends Model
{

    protected $table = 'advertising_campaign_tasks';

    public $timestamps = true;

    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }

    public function smsMmsMessages()
    {
        return $this->hasMany('App\Models\Message\SmsMmsMessage', 'advertising_campaigns_tasks_id');
    }

}
