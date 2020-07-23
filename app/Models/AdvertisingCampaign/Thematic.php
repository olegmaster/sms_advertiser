<?php

namespace App\Models\AdvertisingCampaign;

use Illuminate\Database\Eloquent\Model;

class Thematic extends Model
{
    protected $fillable = ['name', 'status', 'user_id'];
}
