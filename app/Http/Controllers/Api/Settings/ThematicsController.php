<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThematicsCreateRequest;
use App\Models\AdvertisingCampaign\Thematic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThematicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $result = DB::table('thematics')
            ->leftJoin('users', 'thematics.user_id', '=', 'users.id')
            ->select('thematics.*',
                'users.name as username')
            ->paginate(10000);
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo 'create';
        die;
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
        if (!isset($data['status'])) {
            $data['status'] = 1;
        }

        $data['user_id'] = Auth::id() ?? 1;

        if (empty($data['name'])) {
            return response()->json(['status' => false, 'message' => 'Ошибка, имя пустое']);
        }

        $item = Thematic::where('name', $data['name'])->get();

       // print_r(count($item) !== 0);die;

        if (count($item) !== 0) {
            return response()->json(['status' => false, 'message' => 'Такая тематика уже есть']);
        }

        $item = (new Thematic())->create($data);

        if ($item) {
            return response()->json(['status' => true, 'data' => [
                'id' => $item->id,
                'name' => $item->name,
                'status' => $item->status,
                'created_at' => $item->created_at
            ],
                'message' => 'Тематика создана'

            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'не удалось создать тематику']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'show';
        die;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo 'edit';
        die;
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
        $item = Thematic::find($id);

        if (empty($item)) {
            return response()->json(['status' => false]);
        }

        $data = $request->all();
        //print_r($data);die;
        $item
            ->fill($data)
            ->save();

        return response()->json(['status' => true]);
    }

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
