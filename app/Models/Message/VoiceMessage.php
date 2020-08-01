<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model,
    App\Traits\RealPagination;

class VoiceMessage extends Model
{
    use RealPagination;

    protected $table = 'voice_messages';

    public $timestamps = true;


    public function advertisingCampaign()
    {
        return $this->belongsTo('App\Models\AdvertisingCampaign\AdvertisingCampaignTask', 'advertising_campaign_tasks_id' );
    }

    /**
     * Заготовка запроса по айди
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeById($query, $id)
    {
        if (!is_null($id))
            return $query->where($this->table . '.id', $id);
        else
            return $query;
    }
}
