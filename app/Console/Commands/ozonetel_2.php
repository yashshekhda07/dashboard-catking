<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

//use App\CronsLogs;

class ozonetel_2 extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ozonetel_2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ozonetel_2';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {


        $date = date('Y-m-d', strtotime("-1 days"));

        $from_date = urlencode("$date 00:00:00");
        $to_date = urlencode("$date 23:59:59");

        $api_key = 'KKcff82442b04d72db9ff8b9dd1b22866b';
        $user_name = 'catking';
        // $from_date = '2023-11-06%2009%3A00%3A00';
        // $to_date = '2023-11-06%2010%3A23%3A00';
        $format = 'json';
        $url = 'https://in1-ccaas-api.ozonetel.com/cloudAgentRestAPI/index.php/CloudAgent/CloudAgentAPI/getCallLogs?api_key=' . $api_key . '&user_name=' . $user_name . '&from_date=' . $from_date . '&to_date=' . $to_date . '&format=' . $format;


        $this->info('api call: ' . "-------------------------------------------------------------------------------------------");
        $this->info('response: ' . $url);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=b553e934fc1fc26f734fe229ebfbb42b',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $this->info('response: ' . $response);
        $data = json_decode($response, true);



        // print_r($data);
        // exit;
        if (isset($data['message']) && !empty($data['message']) && $data['message'] != 'no record found') {
            $data_obj = array();
            $update_obj = array();

            $UCID_list = array_column($data['message'], 'UCID');

            $already_avail_data = DB::table('ozonetel_webhook')->whereIn('UCID', $UCID_list)->pluck('id', 'UCID')->toArray();

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
                    $update_obj[$key]['Campaign'] = isset($message['CampaignName']) ? $message['CampaignName'] : "";
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
                    $data_obj[$key]['Campaign'] = isset($message['CampaignName']) ? $message['CampaignName'] : "";
                    $data_obj[$key]['created_at'] = date('Y-m-d H:i:s');
                }
            }

            if (!empty($update_obj)) {
                foreach ($update_obj as $update_o) {
                    DB::table('ozonetel_webhook')
                            ->where('id', $update_o['id'])
                            ->update($update_o);
                }
            }
            DB::table('ozonetel_webhook')->insert($data_obj);
        }
        $this->info('Demo Cron. Date: ' . date("Y-m-d H:i:s"));
    }

}
