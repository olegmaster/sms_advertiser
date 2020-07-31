<?php

namespace App\Models\AdvertisingCampaign;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Thematic extends Model
{
    protected $fillable = ['name', 'status', 'user_id'];

    public const ACTIVATE_THEMATICS_ACTION = 1;
    public const DEACTIVATE_THEMATICS_ACTION = 2;
    public const UPDATE_THEMATICS_ACTION = 3;

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (!isset($model->status)) {
                $model->status = 1;
            }
            if (!isset($model->user_id)) {
                $model->user_id = Auth::id() ?? 1;
            }
        });
    }
}
