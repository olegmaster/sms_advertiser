<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class MmsMediaFilesGroup extends Model
{

    protected $table = 'mms_media_files_groups';

    public $timestamps = false;

    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }

    public function smsMmsMessage()
    {
        return $this->hasOne('App\Models\Message\SmsMmsMessage');
    }

    public function mmsMediaFiles()
    {
        return $this->hasMany('App\Models\Message\MmsMediaFile', 'mms_media_files_groups_id');
    }
}
