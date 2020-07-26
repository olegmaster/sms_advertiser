<?php

namespace App\Models\Settings\Proxies;

use Illuminate\Database\Eloquent\Model,
    App\Models\BuilderWithPagination;

class Proxies extends Model
{
    const PROXY_TYPES = array(
        'http' => 0,
        'socks4' => 1,
        'socks5' => 2,
    );
    protected $table = 'proxies';
    protected $fillable = ['ip', 'port', 'login', 'password', 'type', 'status'];

    public function newEloquentBuilder($query)
    {
        return new BuilderWithPagination($query);
    }
}
