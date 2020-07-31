<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseGenerator
{
    /**
     * generates API response
     * @param $data
     * @param int $errorCode
     * @param string $message
     * @return array
     */
    public static function makeResponse($data = [], int $errorCode = 0, string $message = ''): array
    {
        $return = [];
        $return['errorCode'] = $errorCode;
        $return['message'] = $message;
        $return['data'] = array(
            'stat' => ['itemsCount' => $data->total()],
            'items' => $data->items()
        );
        return $return;
    }
}
