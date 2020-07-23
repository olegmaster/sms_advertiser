<?php

namespace App\Models\Settings\Proxies;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class Proxies extends Model
{
    protected $table = 'proxies';

    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }
}
