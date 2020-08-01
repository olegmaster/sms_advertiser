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
    App\Models\Message\VoiceMessage,
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
                return $query->join('advertising_campaign_tasks', 'sms_mms_messages.advertising_campaign_tasks_id', '=', 'advertising_campaign_tasks.id' )
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
            SmsMmsMessage::DESTINATION_TYPE_SMS_MMS_AFTER_HEARD
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
                return $query->join('advertising_campaign_tasks', 'sms_mms_messages.advertising_campaign_tasks_id', '=', 'advertising_campaign_tasks.id' )
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
    public function voice( Request $request)
    {

        $itemsPerPage = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 25;
        $page = $request->has('page') ? $request->get('page') : 1;
        $filter = $request->has('filter') ? json_decode($request->get('filter'),true) : null;

        $obj_id = $filter && isset($filter['obj_id']) && !empty($filter['obj_id']) ? intval($filter['obj_id']) : null;
        $thematics_id = $filter && isset($filter['thematics_id']) && (intval($filter['thematics_id']) > 0) ? intval($filter['thematics_id']) : null;

        $messages = VoiceMessage::addPagination($itemsPerPage, $page);

        $data = $messages
            ->ById($obj_id)
            ->with('advertisingCampaign.user','advertisingCampaign.thematics')
            ->when(!is_null($thematics_id), function ($query) use($thematics_id) {
                return $query->join('advertising_campaign_tasks', 'voice_messages.advertising_campaign_tasks_id', '=', 'advertising_campaign_tasks.id' )
                    ->where('advertising_campaign_tasks.thematics_id', '=', $thematics_id);
            })
            ->select('voice_messages.*')
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
}