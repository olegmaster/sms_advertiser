<?php

namespace App\Models\Settings\Proxies;

use Illuminate\Database\Eloquent\Model,
    App\Traits\RealPagination;

class Proxies extends Model
{
    use RealPagination;

    const NOT_BANNED = 0;
    const PARTLY_BANNED = 1;
    const BANNED = 2;

    const PROXY_TYPES = array(
        'http' => 0,
        'socks4' => 1,
        'socks5' => 2,
    );
    protected $table = 'proxies';
    protected $fillable = ['ip', 'port', 'login', 'password', 'type', 'status'];

    public function checkingStates()
    {
        return $this->hasMany('App\Models\Settings\Proxies\ProxyCheckingState', 'proxy_id');
    }


}
