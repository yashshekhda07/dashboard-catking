<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SupportController extends Controller
{
    public $startDate, $endDate, $lastStartDate, $lastEndDate, $previousStartDate, $previousEndDate;
    public $ozonTelCampaignNotIncluded = [
        "CSInbound_918069067470",
        "Sneha_Progressive",
        "Vibha_Progessive",
        "Harshita_Progessive",
        "Minali_Progressive"
    ];
    public function getStartEndDate($date = 'today')
    {
        if ($date == 'yesterday') {
            $this->startDate = Carbon::yesterday()->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::yesterday()->endOfDay()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::yesterday()->subYear()->startOfDay()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::yesterday()->subYear()->endOfDay()->format('Y-m-d H:i:s');

            $this->previousStartDate = Carbon::yesterday()->subDay()->startOfDay()->format('Y-m-d H:i:s');
            $this->previousEndDate = Carbon::yesterday()->subDay()->endOfDay()->format('Y-m-d H:i:s');
        } elseif ($date == 'this_week') {
            $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->startOfWeek()->subYear()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->endOfWeek()->subYear()->format('Y-m-d H:i:s');

            $this->previousStartDate = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d H:i:s');
            $this->previousEndDate = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d H:i:s');
        } elseif ($date == 'last_month') {
            $this->startDate = Carbon::now()->subMonths()->startOfMonth()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->subMonths()->endOfMonth()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->subYear()->subMonths()->startOfMonth()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear()->subMonths()->endOfMonth()->format('Y-m-d H:i:s');

            $this->previousStartDate = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d H:i:s');
            $this->previousEndDate = Carbon::now()->subMonths(2)->endOfMonth()->format('Y-m-d H:i:s');
        } elseif ($date == '3_months') {
            $this->startDate = Carbon::now()->subMonths(3)->startOfMonth()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->subMonths()->endOfMonth()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->subYear()->subMonths(3)->startOfMonth()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear()->subMonths()->endOfMonth()->format('Y-m-d H:i:s');

            $this->previousStartDate = Carbon::now()->subMonths(6)->startOfMonth()->format('Y-m-d H:i:s');
            $this->previousEndDate = Carbon::now()->subMonths(4)->endOfMonth()->format('Y-m-d H:i:s');
        } elseif ($date == '6_months') {
            $this->startDate = Carbon::now()->subMonths(6)->startOfMonth()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->subMonths()->endOfMonth()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->subYear()->subMonths(6)->startOfMonth()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear()->subMonths()->endOfMonth()->format('Y-m-d H:i:s');

            $this->previousStartDate = Carbon::now()->subMonths(12)->startOfMonth()->format('Y-m-d H:i:s');
            $this->previousEndDate = Carbon::now()->subMonths(7)->endOfMonth()->format('Y-m-d H:i:s');
        } elseif ($date == 'this_year') {
            $this->startDate = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->subYear()->startOfYear()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear()->endOfYear()->format('Y-m-d H:i:s');

            $this->previousStartDate = $this->lastStartDate;
            $this->previousEndDate = $this->lastEndDate;
        } elseif ($date == 'last_year') {
            $this->startDate = Carbon::now()->subYear()->startOfYear()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->subYear()->endOfYear()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->subYear(2)->startOfYear()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear(2)->endOfYear()->format('Y-m-d H:i:s');

            $this->previousStartDate = $this->lastStartDate;
            $this->previousEndDate = $this->lastEndDate;
        } else {
            $this->startDate = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

            $this->lastStartDate = Carbon::now()->subYear()->startOfDay()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear()->endOfDay()->format('Y-m-d H:i:s');

            $this->previousStartDate = Carbon::yesterday()->startOfDay()->format('Y-m-d H:i:s');
            $this->previousEndDate = Carbon::yesterday()->endOfDay()->format('Y-m-d H:i:s');
        }
    }

    public function index()
    {
        return view('Admin.Support.index');
    }

    public function fetchCallAndGroupCount(Request $request)
    {
        $date = $request->date;
        $this->getStartEndDate($date);

        if ($date === "custom") {
            $this->startDate = isset($request->startDate) ? Carbon::parse($request->startDate)->startOfDay()->toDateTimeString() : Carbon::now()->startOfDay()->toDateTimeString();
            $this->endDate = isset($request->endDate) ? Carbon::parse($request->endDate)->endOfDay()->toDateTimeString() : Carbon::now()->endOfDay()->toDateTimeString();
        }

        // Fetch call data
        $data = DB::table('ozonetel_webhook')
            ->select(
                DB::raw('SUM(CASE WHEN Disposition LIKE "%Welcome%" THEN 1 ELSE 0 END) as total_welcome_calls'),
                DB::raw('SUM(CASE WHEN Type = "Inbound" THEN 1 ELSE 0 END) as total_incoming_calls'),
                DB::raw('SUM(CASE WHEN Disposition LIKE "%CS Call%" THEN 1 ELSE 0 END) as total_customer_success_calls')
            )
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->whereNotIn('Campaign', $this->ozonTelCampaignNotIncluded)
            ->first();

        // Fetch orders between 5:50 PM of previous day to 5:50 PM of today
        $previousDay = Carbon::now()->subDay()->setTime(17, 50, 0);
        $today = Carbon::now()->setTime(17, 50, 0);
        $total_orders_between_550_to_550 = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$previousDay, $today])
            ->count();

        // Fetch total converted leads
        $total_converted_leads = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'completed')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->count();

        return response()->json([
            'total_welcome_calls' => $data->total_welcome_calls ?? 0,
            'total_incoming_calls' => $data->total_incoming_calls ?? 0,
            'total_customer_success_calls' => $data->total_customer_success_calls ?? 0,
            'total_orders_between_550_to_550' => $total_orders_between_550_to_550,
            'whatspp_group_additions' => 0, // You may need to update this value
            'total_converted_leads' => $total_converted_leads
        ]);
    }

    public function fetchWelcomeCallsData(Request $request)
    {
        $date = $request->date;
        $this->getStartEndDate($date);

        if ($date === "custom") {
            $this->startDate = isset($request->startDate) ? Carbon::parse($request->startDate)->startOfDay()->toDateTimeString() : Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = isset($request->endDate) ? Carbon::parse($request->endDate)->endOfDay()->toDateTimeString() : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        }

        $total_welcome_calls = DB::table('ozonetel_webhook')
            ->where('Disposition', 'LIKE', '%Welcome%')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->count();

        $total_welcome_calls_connected = DB::table('ozonetel_webhook')
            ->where('Disposition', 'LIKE', '%Welcome%')
            ->where('Status', 'Answered')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->count();

        $total_welcome_calls_unanswered = DB::table('ozonetel_webhook')
            ->where('Disposition', 'LIKE', '%Welcome%')
            ->where('Status', 'NotAnswered')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->count();

        return response()->json([
            'total_welcome_calls' => $total_welcome_calls ?? 0,
            'total_welcome_calls_connected' => $total_welcome_calls_connected ?? 0,
            'total_welcome_calls_unanswered' => $total_welcome_calls_unanswered ?? 0,
        ]);
    }

    public function fetchCustomerCallsData(Request $request)
    {
        $date = $request->date;
        $this->getStartEndDate($date);

        if ($date === "custom") {
            $this->startDate = isset($request->startDate) ? Carbon::parse($request->startDate)->startOfDay()->toDateTimeString() : Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = isset($request->endDate) ? Carbon::parse($request->endDate)->endOfDay()->toDateTimeString() : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        }

        $callsData = DB::table('ozonetel_webhook')
            ->select(
                DB::raw('COUNT(*) as total_cs_calls'),
                DB::raw('SUM(CASE WHEN Status = "Answered" THEN 1 ELSE 0 END) as total_cs_connected_calls'),
                DB::raw('SUM(CASE WHEN Status = "NotAnswered" THEN 1 ELSE 0 END) as total_cs_unanswered_calls')
            )
            ->where('Disposition', 'LIKE', '%CS%')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->first();

        return response()->json([
            'total_cs_calls' => $callsData->total_cs_calls ?? 0,
            'total_cs_connected_calls' => (int) $callsData->total_cs_connected_calls ?? 0,
            'total_cs_unanswered_calls' => (int) $callsData->total_cs_unanswered_calls ?? 0,
        ]);
    }

    public function fetchCustomerIncomingCallsData(Request $request)
    {
        $date = $request->date;
        $this->getStartEndDate($date);

        if ($date === "custom") {
            $this->startDate = isset($request->startDate) ? Carbon::parse($request->startDate)->startOfDay()->toDateTimeString() : Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = isset($request->endDate) ? Carbon::parse($request->endDate)->endOfDay()->toDateTimeString() : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        }
        $incoming_calls_data = DB::table('ozonetel_webhook')
            ->select(
                DB::raw('COUNT(*) as total_incoming_calls'),
                DB::raw('SUM(CASE WHEN `Status` = "Answered" THEN 1 ELSE 0 END) as total_incoming_calls_answered'),
                DB::raw('SUM(CASE WHEN `DialStatus` LIKE "%Missed call callback%" THEN 1 ELSE 0 END) as total_missed_calls'),
                DB::raw('SUM(CASE WHEN `DialStatus` LIKE "%Missed call callback%" AND `Status` = "Answered" THEN 1 ELSE 0 END) as total_missed_calls_answered'),
                DB::raw('SUM(CASE WHEN `DialStatus` LIKE "%Missed call callback%" AND `Status` = "NotAnswered" THEN 1 ELSE 0 END) as total_missed_calls_unanswered'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Sales__%" THEN 1 ELSE 0 END) as incoming_call_reason_sales'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Technical__%" THEN 1 ELSE 0 END) as incoming_call_reason_technical'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Refund%" THEN 1 ELSE 0 END) as incoming_call_reason_refund'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Payment%" THEN 1 ELSE 0 END) as incoming_call_reason_payment'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Mentoring%" THEN 1 ELSE 0 END) as incoming_call_reason_mentoring'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Batch%" THEN 1 ELSE 0 END) as incoming_call_reason_batch'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Whatsapp Group%" THEN 1 ELSE 0 END) as incoming_call_reason_whatsapp'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Miscellaneous%" THEN 1 ELSE 0 END) as incoming_call_reason_miscellaneous'),
                DB::raw('SUM(CASE WHEN `Disposition` LIKE "%Live Class%" THEN 1 ELSE 0 END) as incoming_call_reason_live_class')
            )
            ->where('Type', 'Inbound')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->first();

        $total_incoming_calls = $incoming_calls_data->total_incoming_calls ?? 0;
        $total_incoming_reasons = $incoming_calls_data->incoming_call_reason_sales + $incoming_calls_data->incoming_call_reason_technical + $incoming_calls_data->incoming_call_reason_refund + $incoming_calls_data->incoming_call_reason_payment + $incoming_calls_data->incoming_call_reason_mentoring + $incoming_calls_data->incoming_call_reason_batch + $incoming_calls_data->incoming_call_reason_whatsapp + $incoming_calls_data->incoming_call_reason_miscellaneous + $incoming_calls_data->incoming_call_reason_live_class;
        $total_incoming_reasons = $incoming_calls_data->total_incoming_calls ?? 0;

        $incoming_call_reason_sales_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_sales ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_technical_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_technical ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_refund_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_refund ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_payment_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_payment ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_mentoring_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_mentoring ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_batch_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_batch ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_whatsapp_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_whatsapp ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_miscellaneous_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_miscellaneous ?? 0) * 100 / $total_incoming_reasons, 1) : 0;
        $incoming_call_reason_live_class_pr = ($total_incoming_reasons != 0) ? round(($incoming_calls_data->incoming_call_reason_live_class ?? 0) * 100 / $total_incoming_reasons, 1) : 0;


        return response()->json([
            'total_incoming_calls' => $total_incoming_calls,
            'total_incoming_reasons' => $total_incoming_reasons,
            'total_incoming_calls_answered' => $incoming_calls_data->total_incoming_calls_answered ?? 0,
            'total_missed_calls' => $incoming_calls_data->total_missed_calls ?? 0,
            'total_missed_calls_answered' => $incoming_calls_data->total_missed_calls_answered ?? 0,
            'total_missed_calls_unanswered' => $incoming_calls_data->total_missed_calls_unanswered ?? 0,
            'incoming_call_reason_sales' => $incoming_calls_data->incoming_call_reason_sales ?? 0,
            'incoming_call_reason_sales_pr' => $incoming_call_reason_sales_pr,
            'incoming_call_reason_technical' => $incoming_calls_data->incoming_call_reason_technical ?? 0,
            'incoming_call_reason_technical_pr' => $incoming_call_reason_technical_pr,
            'incoming_call_reason_refund' => $incoming_calls_data->incoming_call_reason_refund ?? 0,
            'incoming_call_reason_refund_pr' => $incoming_call_reason_refund_pr ?? 0,
            'incoming_call_reason_payment' => $incoming_calls_data->incoming_call_reason_payment ?? 0,
            'incoming_call_reason_payment_pr' => $incoming_call_reason_payment_pr ?? 0,
            'incoming_call_reason_mentoring' => $incoming_calls_data->incoming_call_reason_mentoring ?? 0,
            'incoming_call_reason_mentoring_pr' => $incoming_call_reason_mentoring_pr ?? 0,
            'incoming_call_reason_batch' => $incoming_calls_data->incoming_call_reason_batch ?? 0,
            'incoming_call_reason_batch_pr' => $incoming_call_reason_batch_pr ?? 0,
            'incoming_call_reason_whatsapp' => $incoming_calls_data->incoming_call_reason_whatsapp ?? 0,
            'incoming_call_reason_whatsapp_pr' => $incoming_call_reason_whatsapp_pr ?? 0,
            'incoming_call_reason_miscellaneous' => $incoming_calls_data->incoming_call_reason_miscellaneous ?? 0,
            'incoming_call_reason_miscellaneous_pr' => $incoming_call_reason_miscellaneous_pr ?? 0,
            'incoming_call_reason_live_class' => $incoming_calls_data->incoming_call_reason_live_class ?? 0,
            'incoming_call_reason_live_class_pr' => $incoming_call_reason_live_class_pr ?? 0,
        ]);
    }

    public function getWords(Request $request)
    {
        $type = $request->type;
        $words = DB::table('ozonetel_webhook')->select('Comments');
        if ($type == "positive") {
            $words = $words->where('Comments', 'LIKE', '%voc_p_%');
        } else {
            $words = $words->where('Comments', 'LIKE', '%voc_n_%');
        }
        $words = $words->pluck('Comments')->toArray();
        $words = array_map(function ($item) use ($type) {
            if ($type == "positive") {
                return str_replace('voc_p_', '', $item);
            } else {
                return str_replace('voc_n_', '', $item);
            }
        }, $words);

        $words_arr = [];
        foreach ($words as $key => $word) {
            $words_arr[] = [
                'key' => $word,
                'value' => rand(1, 2)
            ];
        }

        return response()->json([
            'words' => $words_arr
        ]);
    }

    public function freshDeskData(Request $request)
    {
        $apiUrl = 'https://catking.freshdesk.com/api/v2/';
        $apiKey = 'eE3tEkoVcmJOpWU3YJof';
        try {
            $previousDay6PM = date('Y-m-d', strtotime('yesterday')) . 'T18:00:00Z';
            $today6PM = date('Y-m-d') . 'T18:00:00Z';
            $response = Http::withBasicAuth($apiKey, '')->get($apiUrl);

            $resolved_tickets = $apiUrl . '/search/tickets?query=%22status%3A4%22%0A';
            $resolved_tickets = $this->curl_freshDeskData($resolved_tickets);
            $resolved_tickets = !empty($resolved_tickets['results']) ? count($resolved_tickets['results']) : 0;

            $email_tickets = $apiUrl . '/tickets';
            $email_tickets = $this->curl_freshDeskData($email_tickets);

            $escalated_tickets = $apiUrl . '/search/tickets?query=%22priority%3A3%20OR%20priority%3A4%22%0A';
            $escalated_tickets = $this->curl_freshDeskData($escalated_tickets);
            $escalated_tickets = !empty($escalated_tickets['results']) ? count($escalated_tickets['results']) : 0;

            $hold_tickets = $apiUrl . '/search/tickets?query=%22priority%3A3%20OR%20priority%3A4%22%0A';
            $hold_tickets = $this->curl_freshDeskData($hold_tickets);
            $hold_tickets = !empty($hold_tickets['results']) ? count($hold_tickets['results']) : 0;

            $tickets_arr = [];
            if (!empty($email_tickets)) {
                foreach ($email_tickets as $ticket) {
                    if ($ticket['created_at'] >= $previousDay6PM && $ticket['created_at'] <= $today6PM) {
                        $tickets_arr[] = $ticket;
                    }
                }
            }

            $email_tickets = count($tickets_arr);

            return response()->json([
                'email_tickets' => $email_tickets,
                'resolved_tickets' => $resolved_tickets,
                'escalated_tickets' => $escalated_tickets,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function curl_freshDeskData($url)
    {
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
                'Authorization: Basic ZUUzdEVrb1ZjbUpPcFdVM1lKb2Y6WA==',
                'Cookie: _x_w=2'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function analyticData(Request $request)
    {
        $analyticTerm = $request->analyticTerm;
        if ($analyticTerm == "overview") {
            return view('Admin.Support.overview');
        } else if ($analyticTerm == "agent_analysis") {
            return view('Admin.Support.agent_analysis');
        } else if ($analyticTerm == "courses_analysis") {
            return view('Admin.Support.courses_analysis');
        }
    }

    public function callTransferedData(Request $request)
    {
        $date = $request->date;
        $this->getStartEndDate($date);

        if ($date === "custom") {
            $this->startDate = isset($request->startDate) ? Carbon::parse($request->startDate)->startOfDay()->toDateTimeString() : Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = isset($request->endDate) ? Carbon::parse($request->endDate)->endOfDay()->toDateTimeString() : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        }

        $total_call_transfer = DB::table('ozonetel_webhook')
            ->where('TransferType', '!=', 'No Transfers')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->count();
        $total_call_transfer_to_sales = DB::table('ozonetel_webhook')
            ->where('TransferType', '=', 'Agent')
            ->whereBetween('StartTime', [$this->startDate, $this->endDate])
            ->count();

        return response()->json([
            'total_call_transfer' => $total_call_transfer,
            'total_call_transfer_to_sales' => $total_call_transfer_to_sales,
        ]);
    }
}
