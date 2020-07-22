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
    public function index()
    {
        $proxies = Proxies::all();
        $return = array();
        $return['status'] = 'ok';
        $return['data'] = array(
            'stat' => [],
            'items' => $proxies
        );

        return response()->json($return);
    }
}