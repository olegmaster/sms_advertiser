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
        $result = DB::table('domains')
            ->select('domains.*')
            ->paginate($perPage);
        return $result;
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
