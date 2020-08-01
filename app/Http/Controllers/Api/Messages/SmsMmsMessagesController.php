<?php
/**
 * Created by PhpStorm.
 * User: shera
 * Date: 22.07.2020
 * Time: 13:16
 */

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    Illuminate\Http\Response,
    Illuminate\Database\Eloquent\Model,
    App\Models\Message\SmsMmsMessage,
    Illuminate\Support\Facades\DB;


class SmsMmsMessagesController extends Controller
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
        $filter = $request->has('filter') ? json_decode($request->get('filter'),true) : null;
        $sms_destinations_types = array(
            SmsMmsMessage::DESTINATION_TYPE_SMS_ADD,
            SmsMmsMessage::DESTINATION_TYPE_SMS_MMS_TON_1,
            SmsMmsMessage::DESTINATION_TYPE_SMS_MMS_AFTER_HEARD,
            SmsMmsMessage::DESTINATION_TYPE_SMS_AUTOANSWER
        );

        $destination_type = $filter && isset($filter['destination_type']) && (intval($filter['destination_type']) >=0 ) ? $filter['destination_type'] : $sms_destinations_types;
        $text = $filter && isset($filter['text']) && !empty($filter['text'])? $filter['text'] : null;
        $obj_id = $filter && isset($filter['obj_id']) && !empty($filter['obj_id']) ? intval($filter['obj_id']) : null;
        $thematics_id = $filter && isset($filter['thematics_id']) && (intval($filter['thematics_id']) > 0) ? intval($filter['thematics_id']) : null;

        $messages = SmsMmsMessage::addPagination($itemsPerPage, $page);

        $data = $messages
            ->OfMessageType(0)
            ->ById($obj_id)
            ->ByText($text)
            ->OfDestinationType($destination_type)
            ->with('advertisingCampaign.user','advertisingCampaign.thematics')
            ->when(!is_null($thematics_id), function ($query) use($thematics_id) {
                return $query->join('advertising_campaign_tasks', 'sms_mms_messages.advertising_campaigns_tasks_id', '=', 'advertising_campaign_tasks.id' )
                    ->where('advertising_campaign_tasks.thematics_id', '=', $thematics_id);
            })
            ->select('sms_mms_messages.*')
            ->get();

        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
            'stat' => ['itemsCount' => $messages->count()],
            'items' => $data->toArray()
        );

        return response()->json($return);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function mms( Request $request)
    {

        $itemsPerPage = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 25;
        $page = $request->has('page') ? $request->get('page') : 1;
        $filter = $request->has('filter') ? json_decode($request->get('filter'),true) : null;
        $sms_destinations_types = array(
            SmsMmsMessage::DESTINATION_TYPE_SMS_ADD,
            SmsMmsMessage::DESTINATION_TYPE_SMS_MMS_TON_1,
            SmsMmsMessage::DESTINATION_TYPE_SMS_MMS_AFTER_HEARD,
            SmsMmsMessage::DESTINATION_TYPE_SMS_AUTOANSWER
        );

        $destination_type = $filter && isset($filter['destination_type']) && (intval($filter['destination_type']) >=0 ) ? $filter['destination_type'] : $sms_destinations_types;
        $text = $filter && isset($filter['text']) && !empty($filter['text'])? $filter['text'] : null;
        $obj_id = $filter && isset($filter['obj_id']) && !empty($filter['obj_id']) ? intval($filter['obj_id']) : null;
        $thematics_id = $filter && isset($filter['thematics_id']) && (intval($filter['thematics_id']) > 0) ? intval($filter['thematics_id']) : null;

        $messages = SmsMmsMessage::addPagination($itemsPerPage, $page);

        $data = $messages
            ->OfMessageType(1)
            ->ById($obj_id)
            ->ByText($text)
            ->OfDestinationType($destination_type)
            ->with('advertisingCampaign.user','advertisingCampaign.thematics', 'mediaFilesGroup.mmsMediaFiles')
            ->when(!is_null($thematics_id), function ($query) use($thematics_id) {
                return $query->join('advertising_campaign_tasks', 'sms_mms_messages.advertising_campaigns_tasks_id', '=', 'advertising_campaign_tasks.id' )
                    ->where('advertising_campaign_tasks.thematics_id', '=', $thematics_id);
            })
            ->select('sms_mms_messages.*')
            ->get();

        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
            'stat' => ['itemsCount' => $messages->count()],
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

        if (!$return['errorCode'])
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

        if (!$return['errorCode'])
            Proxies::whereIn('id', $jsonData['ids'])->update(array('status' => $jsonData['value']));


        return response()->json($return);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jsonData = json_decode( $request->all()['proxies'], true);
        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $dataForInsert = array();

        //Если это из списка
        if ($jsonData['source_type'] == 1)
            $proxiesStr = $jsonData['proxies'];
        else {
            // Если это из файла
            $file = $request->file('file');
            $proxiesStr = file_get_contents($file->getRealPath());
        }
        $proxies = array_map('trim', explode("\n", $proxiesStr ));

        foreach ( $proxies as $proxy_str ) {
            if ( preg_match('`(?:(http|socks4|socks5)://)?(?:([\w_\-][\w\d_\-]*):([\w\-_][\w\d\-_]*)@)?((?:\d{1,3}.){3}.\d{1,3}):(\d{2,5})`si',$proxy_str, $proxy) ) {
                $dataForInsert[] = array(
                    'type' => empty($proxy[1]) ? $jsonData['type'] : Proxies::PROXY_TYPES[$proxy[1]],
                    'ip' => $proxy[4],
                    'port' => $proxy[5],
                    'login' => $proxy[2],
                    'password' => $proxy[3],
                    'status' => 1,
                    'is_banned' => 0,
                    'busy_by_task_id' => 0,
                    'last_checked_status' => '',
                    'check_state' => 0
                );
            }
        }

        Proxies::insert($dataForInsert);

        $return['data'] = array(
        );
        return response()->json($return);
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
        $jsonData = json_decode( $request->getContent(), true);

        $proxy  = Proxies::find($id);

        $return = array();
        $return['errorCode'] = 0;
        $return['message'] = '';
        $return['data'] = array(
        'json' => $jsonData
        );

        if (!$proxy) {
            $return['errorCode'] = 1;
            $return['message'] = 'Обект не найден';
        }

        if (!$return['errorCode'])
            $proxy->update($jsonData);

        return response()->json($return);

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

        if (!$return['errorCode'])
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

        if (!$return['errorCode'])
            Proxies::destroy($jsonData['ids']);


        return response()->json($return);

    }



}