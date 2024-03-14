<?php

use App\Http\Controllers\API\NPFWebHookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/npf-webhook', function (Request $request) {
//     Log::info("npf-webhook");
//     Log::info($request->all());
//     echo json_encode($request->all());
//     exit;
// });
Route::post('/npf-webhook', [NPFWebHookController::class, 'store']);

Route::get('/ozontel-webhook', function () {

    echo 'Demo Cron. Date: ' . date("Y-m-d H:i:s") . PHP_EOL;

   
    exit;


    $date = date('Y-m-d', strtotime("-1 days"));
    ;
    $startdate = urlencode("$date 00:00:00");
    $enddate = urlencode("$date 23:59:59");

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://in1-ccaas-api.ozonetel.com/cloudAgentRestAPI/index.php/CloudAgent/CloudAgentAPI/getCallLogs?api_key=KKcff82442b04d72db9ff8b9dd1b22866b&user_name=catking&from_date=' . $startdate . '&to_date=' . $enddate . '&format=json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=5f87d30d5b727cd0cb7f62831be09c83'
        ),
    ));
    $response = curl_exec($curl);

    $data = json_decode($response, true);

    if (isset($data['message']) && !empty($data['message']) && $data['message'] != 'no record found') {
        $data_obj = array();
        $update_obj = array();

        $UCID_list = array_column($data['message'], 'UCID');

        $table_name = "ozonetel_webhook";

        $already_avail_data = DB::table($table_name)->whereIn('UCID', $UCID_list)->pluck('id', 'UCID')->toArray();

//            $data['message'][] = (array) $tmp_data;

        foreach ($data['message'] as $key => $message) {
            if (in_array($message['UCID'], array_keys($already_avail_data))) {
                $update_obj[$key]['id'] = $already_avail_data[$message['UCID']];
                $update_obj[$key]['UCID'] = $message['UCID'];
                $update_obj[$key]['monitorUCID'] = $message['monitorUCID'];
                $update_obj[$key]['UUI'] = $message['UUI'];
                $update_obj[$key]['Did'] = $message['Did'];
                $update_obj[$key]['Location'] = $message['Location'];
                $update_obj[$key]['StartTime'] = $message['StartTime'];
                $update_obj[$key]['CallerID'] = $message['CallerID'];
                $update_obj[$key]['PhoneName'] = $message['PhoneName'];
                $update_obj[$key]['Skill'] = $message['Skill'];
                $update_obj[$key]['EndTime'] = $message['EndTime'];
                $update_obj[$key]['TimeToAnswer'] = $message['TimeToAnswer'];
                $update_obj[$key]['Duration'] = $message['Duration'];
                $update_obj[$key]['FallBackRule'] = $message['FallBackRule'];
                $update_obj[$key]['DialedNumber'] = $message['DialedNumber'];
                $update_obj[$key]['Type'] = $message['Type'];
                $update_obj[$key]['AgentID'] = $message['AgentID'];
                $update_obj[$key]['AgentUniqueID'] = $message['AgentUniqueID'];
                $update_obj[$key]['AgentName'] = $message['AgentName'];
                $update_obj[$key]['Disposition'] = $message['Disposition'];
                $update_obj[$key]['HangupBy'] = $message['HangupBy'];
                $update_obj[$key]['Status'] = $message['Status'];
                $update_obj[$key]['AudioFile'] = $message['AudioFile'];
                $update_obj[$key]['TransferType'] = $message['TransferType'];
                $update_obj[$key]['TransferredTo'] = $message['TransferredTo'];
                $update_obj[$key]['Comments'] = $message['Comments'];
                $update_obj[$key]['DialStatus'] = $message['DialStatus'];
                $update_obj[$key]['ApiKey'] = isset($message['ApiKey']) ? $message['ApiKey'] : "";
                $update_obj[$key]['AgentStatus'] = $message['AgentStatus'];
                $update_obj[$key]['CustomerStatus'] = $message['CustomerStatus'];
                $update_obj[$key]['Campaign'] = isset($message['Campaign']) ? $message['Campaign'] : "";
                $update_obj[$key]['updated_at'] = date('Y-m-d H:i:s');
            } else {
                $data_obj[$key]['UCID'] = $message['UCID'];
                $data_obj[$key]['monitorUCID'] = $message['monitorUCID'];
                $data_obj[$key]['UUI'] = $message['UUI'];
                $data_obj[$key]['Did'] = $message['Did'];
                $data_obj[$key]['Location'] = $message['Location'];
                $data_obj[$key]['StartTime'] = $message['StartTime'];
                $data_obj[$key]['CallerID'] = $message['CallerID'];
                $data_obj[$key]['PhoneName'] = $message['PhoneName'];
                $data_obj[$key]['Skill'] = $message['Skill'];
                $data_obj[$key]['EndTime'] = $message['EndTime'];
                $data_obj[$key]['TimeToAnswer'] = $message['TimeToAnswer'];
                $data_obj[$key]['Duration'] = $message['Duration'];
                $data_obj[$key]['FallBackRule'] = $message['FallBackRule'];
                $data_obj[$key]['DialedNumber'] = $message['DialedNumber'];
                $data_obj[$key]['Type'] = $message['Type'];
                $data_obj[$key]['AgentID'] = $message['AgentID'];
                $data_obj[$key]['AgentUniqueID'] = $message['AgentUniqueID'];
                $data_obj[$key]['AgentName'] = $message['AgentName'];
                $data_obj[$key]['Disposition'] = $message['Disposition'];
                $data_obj[$key]['HangupBy'] = $message['HangupBy'];
                $data_obj[$key]['Status'] = $message['Status'];
                $data_obj[$key]['AudioFile'] = $message['AudioFile'];
                $data_obj[$key]['TransferType'] = $message['TransferType'];
                $data_obj[$key]['TransferredTo'] = $message['TransferredTo'];
                $data_obj[$key]['Comments'] = $message['Comments'];
                $data_obj[$key]['DialStatus'] = $message['DialStatus'];
                $data_obj[$key]['ApiKey'] = isset($message['ApiKey']) ? $message['ApiKey'] : "";
                $data_obj[$key]['AgentStatus'] = $message['AgentStatus'];
                $data_obj[$key]['CustomerStatus'] = $message['CustomerStatus'];
                $data_obj[$key]['Campaign'] = isset($message['Campaign']) ? $message['Campaign'] : "";
                $data_obj[$key]['created_at'] = date('Y-m-d H:i:s');
            }
        }

        if (!empty($update_obj)) {
            foreach ($update_obj as $update_o) {
                DB::table($table_name)
                        ->where('id', $update_o['id'])
                        ->update($update_o);
            }
        }
        DB::table($table_name)->insert($data_obj);
    }

    echo 'Demo Cron. Date: ' . date("Y-m-d H:i:s");

    curl_close($curl);
    exit;
});
