<?php

namespace App\Models\Targeting;

use Illuminate\Database\Eloquent\Model,
    App\Traits\RealPagination;

class Board extends Model
{
    use RealPagination;

    protected $table = 'boards';

    public $timestamps = true;
}
