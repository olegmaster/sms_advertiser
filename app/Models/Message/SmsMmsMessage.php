<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class SmsMmsMessage extends Model
{
    const SMS_TYPE = 0;
    const MMS_TYPE = 1;
    const DESTINATION_TYPE_SMS_ADD = 0;
    const DESTINATION_TYPE_MMS_ADD = 1;
    const DESTINATION_TYPE_SMS_MMS_TON_1 = 2;
    const DESTINATION_TYPE_SMS_MMS_AFTER_HEARD = 3;
    const DESTINATION_TYPE_SMS_DIALOG_OUT = 4;
    const DESTINATION_TYPE_SMS_DIALOG_IN = 5;
    const DESTINATION_TYPE_SMS_AUTOANSWER = 6;

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
        return $this->belongsTo('App\Models\AdvertisingCampaign\AdvertisingCampaignTask', 'advertising_campaigns_tasks_id' );
    }

    /**
     * Заготовка запроса по айди
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $text
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByText($query, $text)
    {
        if (!is_null($text))
            return $query->where($this->table . '.text','like', '%' . $text . '%' );
        else
            return $query;
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

    /**
     * Заготовка запроса тип обекта: смс или ммс
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfMessageType($query, $type)
    {
        if (!is_null($type))
            return $query->where($this->table . '.message_type', $type);
        else
            return $query;
    }

    /**
     * Заготовка запроса назначения сообщения
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $destination_type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDestinationType($query, $destination_type)
    {
        if (!is_null($destination_type) && !is_array($destination_type))
            return $query->where($this->table . '.destination_type', $destination_type);
        else if (is_array($destination_type))
            return $query->whereIn($this->table . '.destination_type', $destination_type);
        else
            return $query;
    }

}
