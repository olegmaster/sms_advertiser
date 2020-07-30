<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class MmsMediaFile extends Model
{

    protected $table = 'mms_media_files';

    public $timestamps = true;

    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }

    public function mediaFielsGroup()
    {
        return $this->belongsTo('App\Models\Message\MmsMediaFilesGroup', 'mms_media_files_groups_id' );
    }
}
