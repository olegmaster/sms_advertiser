<?php

namespace App\Http\Controllers\Api\Settings;

use App\Models\AdvertisingCampaign\Simbank;
use App\Repositories\SimbanksRepository;
use App\Services\ApiResponseGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SimbanksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param SimbanksRepository $simbanksRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function index(SimbanksRepository $simbanksRepository, Request $request)
    {
        $itemsPerPage = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 25;

        $data = $simbanksRepository->getAllWithPaginate($itemsPerPage);

        return response()->json(ApiResponseGenerator::makeResponse($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->input();

        $item = (new Simbank())->create($data);

        if ($item) {
            return response()->json(ApiResponseGenerator::makeResponse(['id' => $item->id]));

        } else {
            return response()->json(ApiResponseGenerator::makeResponse([], 1));
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
            case Simbank::ACTIVATE_ACTION:
                $data = [
                    'status' => Simbank::ACTIVE_STATUS
                ];
                break;
            case Simbank::DEACTIVATE_ACTION:
                $data = [
                    'status' => Simbank::INACTIVE_STATUS
                ];
                break;
            case Simbank::UPDATE_SIMBANK_DATA_ACTION:
                $data = [
                    'name' => $jsonData['name'],
                    'sync_settings' => $jsonData['sync_settings'],
                ];
                break;

            default:
                return response()->json(ApiResponseGenerator::makeResponse([], 2, 'Ошибка определения действия'));
        }

        if (!$jsonData || !isset($jsonData['value']) || !isset($jsonData['ids']) || !sizeof($jsonData['ids'])) {
            return response()->json(ApiResponseGenerator::makeResponse([], 2, 'Не пераданны необходимые данные'));
        }

        Simbank::whereIn('id', $jsonData['ids'])->update($data);

        return response()->json(ApiResponseGenerator::makeResponse());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $jsonData = $request->input();

        $ids = $jsonData['ids'] ?? null;

        if($ids && $ids instanceof \Countable) {
           Simbank::destroy($ids);
            response()->json([], 0);
        }

        response()->json([], 2);
    }
}
