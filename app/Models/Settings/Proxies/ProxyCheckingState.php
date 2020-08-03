<?php

namespace App\Models\Settings\Proxies;

use Illuminate\Database\Eloquent\Model,
    App\Traits\RealPagination;

class ProxyCheckingState extends Model
{
    use RealPagination;

    protected $table = 'proxy_checking_states';

    public function proxy()
    {
        return $this->belongsTo('App\Models\Settings\Proxies\Proxies', 'proxy_id' );
    }
    public function board()
    {
        return $this->belongsTo('App\Models\Targeting\Board', 'board_id' );
    }


}
