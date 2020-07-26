<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Repositories\DomainsRedirectsRepository;
use Illuminate\Http\Request;

class DomainsRedirectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DomainsRedirectsRepository $domainsRedirectsRepository
     * @param int $itemsPerPage
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DomainsRedirectsRepository $domainsRedirectsRepository, $itemsPerPage = 25)
    {

        $data = $domainsRedirectsRepository->getAllWithPaginate($itemsPerPage);

        dd($data);

        $return = [];
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
            'stat' => ['itemsCount' => $data->count()],
            'items' => $data->toArray()
        );

        return response()->json($return);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
