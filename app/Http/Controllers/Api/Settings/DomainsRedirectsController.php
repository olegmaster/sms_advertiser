<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\DomainsRedirects\Domain;
use App\Repositories\DomainsRedirectsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DomainsRedirectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DomainsRedirectsRepository $domainsRedirectsRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function index(DomainsRedirectsRepository $domainsRedirectsRepository, Request $request)
    {
        $itemsPerPage = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 25;

        $data = $domainsRedirectsRepository->getAllWithPaginate($itemsPerPage);

        $return = [];
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
            'stat' => ['itemsCount' => $data->total()],
            'items' => $data->items()
        );

        return response()->json($return);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->input();

        $item = (new Domain())->create($data);

        if ($item) {
            return response()->json(['errorCode' => 0, 'data' => [
                'id' => $item->id,
            ],
                'message' => __('messages.domain_created')
            ]);
        } else {
            return response()->json(['errorCode' => 1, 'message' => __('messages.domain_creation_failed')]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $jsonData = $request->input();

        switch ($jsonData['value']) {
            case 1:
                $data = [
                    'status' => 1
                ];
                break;
            case 2:
                $data = [
                    'status' => 0
                ];
                break;
            case 3:
                $data = [
                    'is_banned' => 1
                ];
                break;
            case 4:
                $data = [
                    'is_banned' => 0
                ];
                break;
            case 5:
                $data = [
                    'is_frozen' => 1
                ];
                break;
            case 6:
                $data = [
                    'is_frozen' => 0
                ];
                break;
            case 7:
                $data = [
                    'domain' => $jsonData['domain'],
                    'freeze_hours' => $jsonData['freeze_hours'],
                    'spam_limit' => $jsonData['spam_limit']
                ];
                break;
            default:
                $data = [];
        }

        $return = [];
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array();

        if (!$jsonData || !isset($jsonData['value']) || !isset($jsonData['ids']) || !sizeof($jsonData['ids'])) {
            $return['errorCode'] = 2;
            $return['message'] = 'Не пераданны необходимые данные';
        }

        if (!$return['errorCode'])
            Domain::whereIn('id', $jsonData['ids'])->update($data);


        return response()->json($return);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (Domain::destroy($id)) {
            return response()->json(['errorCode' => 0]);
        } else {
            return response()->json(['errorCode' => 1]);
        }
    }
}
