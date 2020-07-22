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
    Illuminate\Database\Eloquent\Model;


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
        return response()->json('Привет всем!');
    }
}