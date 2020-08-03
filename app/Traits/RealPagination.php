<?php
/**
 * Created by PhpStorm.
 * User: shera
 * Date: 01.08.2020
 * Time: 18:29
 */

namespace App\Traits;

use App\Models\BuilderWithPagination;

trait RealPagination
{
    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }
}