<?php


namespace App\Repositories;

use App\Models\AdvertisingCampaign\Thematic as Model;
use Illuminate\Support\Facades\DB;

class ThematicsRepository extends CoreRepository
{

    /**
     * @param int|null $pageSize
     * @return mixed
     */
    public function getAllWithPaginate(int $pageSize = 10000)
    {
        return DB::table('thematics')
            ->leftJoin('users', 'thematics.user_id', '=', 'users.id')
            ->select('thematics.*',
                'users.name as username')
            ->orderBy('id', 'DESC')
            ->paginate($pageSize);
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
