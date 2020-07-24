<?php
/**
 * Created by PhpStorm.
 * User: shera
 * Date: 22.07.2020
 * Time: 13:16
 */

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    Illuminate\Http\Response,
    Illuminate\Database\Eloquent\Model,
    App\Models\Settings\Proxies\Proxies;


class ProxiesController extends Controller
{
    /**
     * Repository instance
     * @var Model $model
     */
    public $model;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( Request $request)
    {
        $itemsPerPage = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 25;
        $page = $request->has('page') ? $request->get('page') : 1;

        $proxies = Proxies::addPagination($itemsPerPage, $page);
        $data  = $proxies->get();
        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
            'stat' => ['itemsCount' => $proxies->count()],
            'items' => $data->toArray()
        );

        return response()->json($return);
    }

    /**
     * Установка статуса у прокси
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setStatus($id, Request $request)
    {
        $proxy  = Proxies::find($id);

        $jsonData = json_decode( $request->getContent(), true);

        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
        );

        if (!$proxy) {
            $return['errorCode'] = 1;
            $return['message'] = 'Обект не найден';
        }

        if (!$jsonData || !isset($jsonData['value']) ) {
            $return['errorCode'] = 2;
            $return['message'] = 'Не пераданны необходимые данные';
        }

        $proxy->update(['status' => $jsonData['value']]);

        return response()->json($return);
    }

    /**
     * Установка статуса у многих проксей
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setMultiplyStatuses(Request $request)
    {
        $jsonData = json_decode( $request->getContent(), true);

        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(

        );

        if (!$jsonData || !isset($jsonData['value']) || !isset($jsonData['ids']) || !sizeof($jsonData['ids']) ) {
            $return['errorCode'] = 2;
            $return['message'] = 'Не пераданны необходимые данные';
        }

        Proxies::whereIn('id', $jsonData['ids'])->update(array('status' => $jsonData['value']));


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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $proxy  = Proxies::find($id);

        $jsonData = json_decode( $request->getContent(), true);


        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
        );

        if (!$proxy) {
            $return['errorCode'] = 1;
            $return['message'] = 'Обект не найден';
        }

        if (!$jsonData || !isset($jsonData['value']) ) {
            $return['errorCode'] = 2;
            $return['message'] = 'Не пераданны необходимые данные';
        }

        $proxy->delete();

        return response()->json($return);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiply(Request $request)
    {
        $jsonData = json_decode( $request->getContent(), true);

        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(

        );

        if (!$jsonData || !isset($jsonData['value']) || !isset($jsonData['ids']) || !sizeof($jsonData['ids']) ) {
            $return['errorCode'] = 2;
            $return['message'] = 'Не пераданны необходимые данные';
        }

        Proxies::destroy($jsonData['ids']);


        return response()->json($return);

    }



}