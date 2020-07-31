<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Requests\ThematicsCreateRequest;
use App\Models\AdvertisingCampaign\Thematic;
use App\Repositories\ThematicsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ThematicsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param ThematicsRepository $repository
     * @return JsonResponse
     */
    public function index(ThematicsRepository $repository, Request $request)
    {
        $itemsPerPage = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 25;

        $data = $repository->getAllWithPaginate($itemsPerPage);

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
     * @param ThematicsCreateRequest $request
     * @return JsonResponse
     */
    public function store(ThematicsCreateRequest $request)
    {
        $data = $request->input();

        $item = (new Thematic())->create($data);

        if ($item) {
            return response()->json(['errorCode' => 0, 'data' => [
                'id' => $item->id,
                'name' => $item->name,
                'status' => $item->status,
                'created_at' => $item->created_at
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
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $jsonData = $request->input();

        switch ($jsonData['value']) {
            case Thematic::ACTIVATE_THEMATICS_ACTION:
                $data = [
                    'status' => 1
                ];
                break;
            case Thematic::DEACTIVATE_THEMATICS_ACTION:
                $data = [
                    'status' => 0
                ];
                break;
            case Thematic::UPDATE_THEMATICS_ACTION:

                $data = [
                    'name' => $jsonData['name'],
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
            Thematic::whereIn('id', $jsonData['ids'])->update($data);


        return response()->json($return);  }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (Thematic::destroy($id)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
