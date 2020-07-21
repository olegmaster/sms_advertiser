<?php


namespace App\Repositories;

use App\Models\AdvertisingCampaign\Thematic as Model;

class ThematicsRepository extends CoreRepository
{

    /**
     * @param int|null $pageSize
     * @return mixed
     */
    public function getAllWithPaginate($pageSize = null)
    {
        $fields = '*';

        return $this->startConditions()
            ->select($fields)
            ->paginate($pageSize);
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
