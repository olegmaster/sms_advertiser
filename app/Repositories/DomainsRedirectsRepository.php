<?php


namespace App\Repositories;

use App\Models\DomainsRedirects\Domain as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class DomainsRedirectsRepository
 * @package App\Repositories
 */
class DomainsRedirectsRepository extends CoreRepository
{

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate(int $perPage = 25)
    {
        return DB::table('thematics')
            ->leftJoin('users', 'thematics.user_id', '=', 'users.id')
            ->select('thematics.*',
                'users.name as username')
            ->paginate($perPage);
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
