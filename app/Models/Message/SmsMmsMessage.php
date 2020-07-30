<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class SmsMmsMessage extends Model
{

    protected $table = 'sms_mms_messages';

    public $timestamps = true;

    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }

    public function mediaFielsGroup()
    {
        return $this->belongsTo('App\Models\Message\MmsMediaFilesGroup', 'mms_media_files_groups_id' );

    }

    public function advertisingCampaign()
    {
        return $this->belongsTo('App\Models\AdvertisingCampaign\AdvertisingCampaignTask', 'advertising_campaign_task_id' );
    }

}
