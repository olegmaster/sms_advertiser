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

}
