<?php


namespace App\Repositories;

use App\Models\DomainsRedirects\Domain as Model;
use Carbon\Carbon;
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
        $cols = implode(',', [
            'domains.id as id',
            'domains.domain as domain',
            'is_banned',
            'status',
            'is_frozen',
            'verified',
            'frozen_on',
            'freeze_hours',
            'spam_limit',
            'sum(all_send_count) as total_count',
            'sum(case when year = ' . Carbon::now()->year . ' then all_send_count else 0 end) as cur_year_count',
            'sum(case when year = ' . Carbon::now()->year . ' and month = ' . Carbon::now()->month . ' then all_send_count else 0 end) as cur_month_count',
            'sum(case when year = ' . Carbon::now()->year . ' and month = ' . Carbon::now()->month . ' and week = ' . Carbon::now()->week . ' then all_send_count else 0 end) as cur_week_count',
            'sum(case when year = ' . Carbon::now()->year . ' and month = ' . Carbon::now()->month . ' and week = ' . Carbon::now()->week . ' and day= ' . Carbon::now()->day . ' then all_send_count else 0 end) as cur_day_count',
            'current_send_count',
            'all_send_count',
            'domains.created_at'
        ]);
        $result = DB::table('domains')
            ->selectRaw($cols)
            ->leftJoin('domains_stat_by_dates', 'domains.id', '=', 'domains_stat_by_dates.domain_id')
            ->groupBy('domains.id')
            ->paginate($perPage);
        return $result;
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
