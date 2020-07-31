<?php


namespace App\Repositories;

use App\Models\AdvertisingCampaign\Simbank as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SimbanksRepository extends CoreRepository
{

    /**
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate(int $perPage = 25)
    {
        $cols = implode(',', [
            'simbanks.id as id',
            'simbanks.name as name',
            'simbanks.capacity as capacity',
            'simbanks.all_sent_count as all_sent_count',
            'simbanks.all_sent_voice_call_count as all_sent_voice_call_count',
            'advertising_campaign_tasks.name as adc_name',
            'simbanks.created_at as created_at'
        ]);
        $result = DB::table('simbanks')
            ->selectRaw($cols)
            ->leftJoin('simbank_to_advertising_campaigns', 'simbanks.id', '=', 'simbank_to_advertising_campaigns.simbank_id')
            ->leftJoin('advertising_campaign_tasks', 'advertising_campaign_tasks.id', '=', 'simbank_to_advertising_campaigns.advertising_campaign_task_id')
            ->orderBy('simbanks.id', 'DESC')
            ->paginate($perPage);
        return $result;
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
