<?php

namespace App\Model\Message;

use Illuminate\Database\Eloquent\Model,
    App\Traits\RealPagination;

class VoiceMessage extends Model
{
    use RealPagination;

    protected $table = 'voice_messages';

    public $timestamps = true;

}
