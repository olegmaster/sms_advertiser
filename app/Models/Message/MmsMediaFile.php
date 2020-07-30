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

}
