<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CEOController extends Controller
{
    public $startDate, $endDate, $lastStartDate, $lastEndDate, $previousStartDate, $previousEndDate;
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $date = isset($request->date) ? $request->date : null;
            $course = isset($request->course) ? $request->course : null;
            if ($date != 'custom') {
                $this->getStartEndDate($date);
            } else {
                $startDate = isset($request->start_date) ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfDay();
                $endDate = isset($request->end_date) ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();
                $daysDifference = $endDate->diffInDays($startDate) + 1;

                $this->startDate = $startDate->format('Y-m-d H:i:s');
                $this->endDate = $endDate->format('Y-m-d H:i:s');

                $this->lastStartDate = $startDate->subYear()->format('Y-m-d H:i:s');
                $this->lastEndDate = $endDate->subYear()->format('Y-m-d H:i:s');

                $startDate = isset($request->start_date) ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfDay();
                $endDate = isset($request->end_date) ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

                $this->previousStartDate = $startDate->subDay($daysDifference)->format('Y-m-d H:i:s');
                $this->previousEndDate = $endDate->subDay($daysDifference)->format('Y-m-d H:i:s');
            }

            // return " startDate : $this->startDate ::::   endDate : $this->endDate :::: Last startDate : $this->lastStartDate ::::  Last endDate : $this->lastEndDate :::: Previous StartDay : $this->previousStartDate  :::: Previous EndDay : $this->previousEndDate";

            if ($course == 'sales') {
                return view('Admin.CeoRevenue.sales');
            } elseif ($course == 'cat') {
                $cat = $this->getCATData();
                // return json_encode($cat);
                return view('Admin.CeoRevenue.cat', compact('cat'));
            } elseif ($course == 'non_cat') {
                $nonCat = $this->getNonCATData();
                // return json_encode($nonCat);
                return view('Admin.CeoRevenue.non_cat', compact('nonCat'));
            } elseif ($course == 'study_abroad') {
                $studyAbroad = $this->getStudyAbroadData();
                // return json_encode($studyAbroad);
                return view('Admin.CeoRevenue.study_abroad', compact('studyAbroad'));
            } elseif ($course == 'undergrad') {
                $undergrad = $this->getUnderGradData();
                // return json_encode($undergrad);
                return view('Admin.CeoRevenue.undergrad', compact('undergrad'));
            } elseif ($course == 'gdpi') {
                $gdpi = $this->getGDPIData();
                // return json_encode($gdpi);
                return view('Admin.CeoRevenue.gdpi', compact('gdpi'));
            } elseif ($course == 'mocks') {
                $mocks = $this->getMocksData();
                // return json_encode($mocks);
                return view('Admin.CeoRevenue.mocks', compact('mocks'));
            } else {
                $revenue = $this->getRevenueData();
                // return json_encode($revenue);
                return view('Admin.CeoRevenue.revenue', compact('revenue'));
            }
            return '<h1>Hello Dashboard</h1>';
        }
        return view('Admin.CeoRevenue.index');
    }

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

            $this->lastStartDate = Carbon::now()->subYear()->startOfWeek()->format('Y-m-d H:i:s');
            $this->lastEndDate = Carbon::now()->subYear()->endOfWeek()->format('Y-m-d H:i:s');

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

    public function getRevenueData()
    {
        $new_total_order_count = $new_total_revenue = $old_total_order_count = $old_total_revenue = $failed_order_repeat_purchase = $new_order_previous_revenue = $old_order_previous_revenue = 0;
        $maxValue = null;
        $new_order_course_category = $old_order_course_category = $failedOrderItemIDs = $data = [];
        // This Year :: total No of enrollment start
        $new_this_year_total = DB::table('orders')->selectRaw('COUNT(id) as count,SUM(total) as total_amount')->where('payment_status', 'completed')->whereBetween('created_at', [$this->startDate, $this->endDate])->first();
        // return $old_this_year_total;
        $old_this_year_total = DB::table('old_orders')->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')->whereBetween('order_date', [$this->startDate, $this->endDate])->first();
        
        $data['this_year_total_enrollments'] = $new_this_year_total->count + $old_this_year_total->count;
        $data['this_year_total_revenue'] = (int) ($new_this_year_total->total_amount + $old_this_year_total->total_amount);
        // This Year :: total No of enrollment end

        // Last Year :: total No of enrollment start
        $new_last_year_total = DB::table('orders')->selectRaw('COUNT(id) as count,SUM(total) as total_amount')->where('payment_status', 'completed')->whereBetween('created_at', [$this->lastStartDate, $this->lastEndDate])->first();

        $old_last_year_total = DB::table('old_orders')->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')->whereBetween('order_date', [$this->lastStartDate, $this->lastEndDate])->first();

        $data['last_year_total_enrollments'] = $new_last_year_total->count + $old_last_year_total->count;
        $lastYearTotalRevenue = (int) ($new_last_year_total->total_amount + $old_last_year_total->total_amount);
        $data['last_year_total_revenue'] = $lastYearTotalRevenue != 0 ? $lastYearTotalRevenue : 1;
        // Last Year :: total No of enrollment end

        // Enrollment Per start
        $data['this_year_total_enrollments_per'] = number_format((($data['this_year_total_enrollments'] * 100) / ($data['this_year_total_enrollments'] + $data['last_year_total_enrollments'])), 2);
        $data['last_year_total_enrollments_per'] = number_format((($data['last_year_total_enrollments'] * 100) / ($data['this_year_total_enrollments'] + $data['last_year_total_enrollments'])), 2);
        $data['this_year_total_revenue_per'] = number_format((($data['this_year_total_revenue'] * 100) / ($data['this_year_total_revenue'] + $data['last_year_total_revenue'])), 2);
        $data['last_year_total_revenue_per'] = number_format((($data['last_year_total_revenue'] * 100) / ($data['this_year_total_revenue'] + $data['last_year_total_revenue'])), 2);
        $data['total_revenue_per'] = number_format(((($data['this_year_total_revenue'] - $data['last_year_total_revenue']) / $data['last_year_total_revenue']) * 100), 2);
        // Enrollment Per end

        // This Year :: enrollments through Installments & EMI start
        $new_this_year_emi_enrollments = DB::table('orders')
            ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->where(function ($q) {
                $q->where('order_items.name', 'like', '%installment%')
                    ->orWhere('order_items.name', 'like', '%emi%');
            })->where('orders.payment_status', 'completed')->first();   

        $old_this_year_emi_enrollments = DB::table('old_orders')
            ->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')
            ->where(function ($q) {
                $q->where('name', 'like', '%installment%')->orWhere('name', 'like', '%emi%');
            })->whereBetween('order_date', [$this->startDate, $this->endDate])->first();

        $data['this_year_emi_enrollments'] = $new_this_year_emi_enrollments->count + $old_this_year_emi_enrollments->count;
        $data['this_year_emi_revenue'] = (int) ($new_this_year_emi_enrollments->total_amount + $old_this_year_emi_enrollments->total_amount);
        // This Year :: enrollments through Installments & EMI end

        // Last Year :: enrollments through Installments & EMI start
        $new_last_year_emi_enrollments = DB::table('orders')
            ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$this->lastStartDate, $this->lastEndDate])
            ->where(function ($q) {
                $q->where('order_items.name', 'like', '%installment%')
                    ->orWhere('order_items.name', 'like', '%emi%');
            })->where('orders.payment_status', 'completed')->first();

        $old_last_year_emi_enrollments = DB::table('old_orders')
            ->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')
            ->where(function ($q) {
                $q->where('name', 'like', '%installment%')->orWhere('name', 'like', '%emi%');
            })->whereBetween('order_date', [$this->lastStartDate, $this->lastEndDate])->first();

        $data['last_year_emi_enrollments'] = $new_last_year_emi_enrollments->count + $old_last_year_emi_enrollments->count;
        $data['last_year_emi_revenue'] = (int) ($new_last_year_emi_enrollments->total_amount + $old_last_year_emi_enrollments->total_amount);
        // Last Year :: enrollments through Installments & EMI end

        // Enrollment through Installments & EMI start
        $totalEMIEnrollments = ($data['this_year_emi_enrollments'] + $data['last_year_emi_enrollments']);
        $totalEMIRevenue = ($data['this_year_emi_revenue'] + $data['last_year_emi_revenue']);

        $data['this_year_emi_enrollments_per'] = number_format((($data['this_year_emi_enrollments'] * 100) / ($totalEMIEnrollments > 0 ? $totalEMIEnrollments : 1)), 2);
        $data['last_year_emi_enrollments_per'] = number_format((($data['last_year_emi_enrollments'] * 100) / ($totalEMIEnrollments > 0 ? $totalEMIEnrollments : 1)), 2);
        $data['this_year_emi_revenue_per'] = number_format((($data['this_year_emi_revenue'] * 100) / ($totalEMIRevenue > 0 ? $totalEMIRevenue : 1)), 2);
        $data['last_year_emi_revenue_per'] = number_format((($data['last_year_emi_revenue'] * 100) / ($totalEMIRevenue > 0 ? $totalEMIRevenue : 1)), 2);
        $lastYearEMIRevenue = $data['last_year_emi_revenue'] != 0 ? $data['last_year_emi_revenue'] : 1;
        $data['total_emi_revenue_per'] = number_format(((($data['this_year_emi_revenue'] - $lastYearEMIRevenue) / $lastYearEMIRevenue) * 100), 2);
        // Enrollment through Installments & EMI end

        // Total No of enrollment Chart And Table start
        $new_today_orders = DB::table('orders')
            ->selectRaw('course_categories.name as course_category_name, count(orders.id) as order_count,sum(orders.total) as total_revenue')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('courses', 'courses.id', '=', 'order_items.course_id')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->where('orders.payment_status', 'completed')
            ->groupBy('course_categories.name')
            ->orderByDesc('order_count')
            ->get();

        $old_today_orders = DB::table('old_orders')
            ->selectRaw('course_categories.name as course_category_name, count(old_orders.id) as order_count,sum(old_orders.total_revenue) as total_revenue')
            ->join('courses', 'courses.name', '=', 'old_orders.name')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('old_orders.order_date', [$this->startDate, $this->endDate])
            ->groupBy('course_categories.name')
            ->orderByDesc('order_count')
            ->get();

        $new_previous_orders = DB::table('orders')
            ->selectRaw('course_categories.name as course_category_name, sum(orders.total) as total_revenue')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('courses', 'courses.id', '=', 'order_items.course_id')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
            ->where('orders.payment_status', 'completed')
            ->groupBy('course_categories.name')
            ->pluck('total_revenue', 'course_category_name')->toArray();

        $old_previous_orders = DB::table('old_orders')
            ->selectRaw('course_categories.name as course_category_name,sum(old_orders.total_revenue) as total_revenue')
            ->join('courses', 'courses.name', '=', 'old_orders.name')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('old_orders.order_date', [$this->previousStartDate, $this->previousStartDate])
            ->groupBy('course_categories.name')
            ->pluck('total_revenue', 'course_category_name')->toArray();

        foreach ($new_today_orders as $order) {
            $new_total_order_count += $order->order_count;
            $new_total_revenue += $order->total_revenue;
            $new_order_course_category['enrollment'][$order->course_category_name] = $order->order_count;
            $new_order_course_category['total_revenue'][$order->course_category_name] = $order->total_revenue;
        }

        foreach ($old_today_orders as $order) {
            $old_total_order_count += $order->order_count;
            $old_total_revenue += $order->total_revenue;
            $old_order_course_category['enrollment'][$order->course_category_name] = $order->order_count;
            $old_order_course_category['total_revenue'][$order->course_category_name] = $order->total_revenue;
        }

        foreach ($new_previous_orders as $pervious) {
            $new_order_previous_revenue += $pervious;
        }

        foreach ($old_previous_orders as $pervious) {
            $old_order_previous_revenue += $pervious;
        }

        $total_order_count = ($new_total_order_count + $old_total_order_count);
        $total_order_count = isset($total_order_count) ? $total_order_count : 1;

        $data['total_revenue']['sum'] = $new_total_revenue + $old_total_revenue;
        $orderPreviousRevenue = $new_order_previous_revenue + $old_order_previous_revenue;
        $totalRevenuePer = min(($data['total_revenue']['sum'] - $orderPreviousRevenue) / ($orderPreviousRevenue > 0 ? $orderPreviousRevenue : 1) * 100, 100);
        $data['total_revenue']['per'] = number_format($totalRevenuePer, 2);

        // total No of enrollment enrollment pie chart start
        $enrollment_CAT = ((isset($new_order_course_category['enrollment']['CAT']) ? $new_order_course_category['enrollment']['CAT'] : 0)
             + (isset($old_order_course_category['enrollment']['CAT']) ? $old_order_course_category['enrollment']['CAT'] : 0));
        $data['enrollment']['CAT'] = $enrollment_CAT != 0 ? number_format(($enrollment_CAT / $total_order_count * 100), 2) : 0;

        $enrollment_GDPI = ((isset($new_order_course_category['enrollment']['GDPI']) ? $new_order_course_category['enrollment']['GDPI'] : 0)
             + (isset($old_order_course_category['enrollment']['GDPI']) ? $old_order_course_category['enrollment']['GDPI'] : 0));
        $data['enrollment']['GDPI'] = $enrollment_GDPI != 0 ? number_format(($enrollment_GDPI / $total_order_count * 100), 2) : 0;

        $enrollment_Mocks = ((isset($new_order_course_category['enrollment']['Mocks']) ? $new_order_course_category['enrollment']['Mocks'] : 0)
             + (isset($old_order_course_category['enrollment']['Mocks']) ? $old_order_course_category['enrollment']['Mocks'] : 0));
        $data['enrollment']['Mocks'] = $enrollment_Mocks != 0 ? number_format(($enrollment_Mocks / $total_order_count * 100), 2) : 0;

        $enrollment_Non_CAT = ((isset($new_order_course_category['enrollment']['Non-CAT']) ? $new_order_course_category['enrollment']['Non-CAT'] : 0) + (isset($old_order_course_category['enrollment']['Non-CAT']) ? $old_order_course_category['enrollment']['Non-CAT'] : 0));
        $data['enrollment']['Non-CAT'] = $enrollment_Non_CAT != 0 ? number_format(($enrollment_Non_CAT / $total_order_count * 100), 2) : 0;

        $enrollment_Study_Abroad = ((isset($new_order_course_category['enrollment']['Study Abroad']) ? $new_order_course_category['enrollment']['Study Abroad'] : 0) + (isset($old_order_course_category['enrollment']['Study Abroad']) ? $old_order_course_category['enrollment']['Study Abroad'] : 0));
        $data['enrollment']['Study Abroad'] = $enrollment_Study_Abroad != 0 ? number_format(($enrollment_Study_Abroad / $total_order_count * 100), 2) : 0;

        $enrollment_UnderGrad = ((isset($new_order_course_category['enrollment']['UnderGrad']) ? $new_order_course_category['enrollment']['UnderGrad'] : 0) + (isset($old_order_course_category['enrollment']['UnderGrad']) ? $old_order_course_category['enrollment']['UnderGrad'] : 0));
        $data['enrollment']['UnderGrad'] = $enrollment_UnderGrad != 0 ? number_format(($enrollment_UnderGrad / $total_order_count * 100), 2) : 0;

        foreach ($data['enrollment'] as $key => $value) {
            if ($maxValue === null || $value > $maxValue) {
                $maxValue = $value;
            }
        }
        $data['enrollment']['maxValue'] = $maxValue;
        // total No of enrollment enrollment pie chart end

        // this day total revenue start
        $data['today_day_total_revenue']['CAT'] = (int) ((isset($new_order_course_category['total_revenue']['CAT']) ? $new_order_course_category['total_revenue']['CAT'] : 0)
             + (isset($old_order_course_category['total_revenue']['CAT']) ? $old_order_course_category['total_revenue']['CAT'] : 0));

        $data['today_day_total_revenue']['GDPI'] = (int) ((isset($new_order_course_category['total_revenue']['GDPI']) ? $new_order_course_category['total_revenue']['GDPI'] : 0)
             + (isset($old_order_course_category['total_revenue']['GDPI']) ? $old_order_course_category['total_revenue']['GDPI'] : 0));

        $data['today_day_total_revenue']['Mocks'] = (int) ((isset($new_order_course_category['total_revenue']['Mocks']) ? $new_order_course_category['total_revenue']['Mocks'] : 0) + (isset($old_order_course_category['total_revenue']['Mocks']) ? $old_order_course_category['total_revenue']['Mocks'] : 0));

        $data['today_day_total_revenue']['Non-CAT'] = (int) ((isset($new_order_course_category['total_revenue']['Non-CAT']) ? $new_order_course_category['total_revenue']['Non-CAT'] : 0) + (isset($old_order_course_category['total_revenue']['Non-CAT']) ? $old_order_course_category['total_revenue']['Non-CAT'] : 0));

        $data['today_day_total_revenue']['Study Abroad'] = (int) ((isset($new_order_course_category['total_revenue']['Study Abroad']) ? $new_order_course_category['total_revenue']['Study Abroad'] : 0) + (isset($old_order_course_category['total_revenue']['Study Abroad']) ? $old_order_course_category['total_revenue']['Study Abroad'] : 0));

        $data['today_day_total_revenue']['UnderGrad'] = (int) ((isset($new_order_course_category['total_revenue']['UnderGrad']) ? $new_order_course_category['total_revenue']['UnderGrad'] : 0) + (isset($old_order_course_category['total_revenue']['UnderGrad']) ? $old_order_course_category['total_revenue']['UnderGrad'] : 0));
        // this day total revenue end

        // previous day total revenue start
        $data['previous_day_total_revenue']['CAT'] = (int) ((isset($new_previous_orders['CAT']) ? $new_previous_orders['CAT'] : 0) + (isset($old_previous_orders['CAT']) ? $old_previous_orders['CAT'] : 0));

        $data['previous_day_total_revenue']['GDPI'] = (int) ((isset($new_previous_orders['GDPI']) ? $new_previous_orders['GDPI'] : 0) + (isset($old_previous_orders['GDPI']) ? $old_previous_orders['GDPI'] : 0));

        $data['previous_day_total_revenue']['Mocks'] = (int) ((isset($new_previous_orders['Mocks']) ? $new_previous_orders['Mocks'] : 0) + (isset($old_previous_orders['Mocks']) ? $old_previous_orders['Mocks'] : 0));

        $data['previous_day_total_revenue']['Non-CAT'] = (int) ((isset($new_previous_orders['Non-CAT']) ? $new_previous_orders['Non-CAT'] : 0) + (isset($old_previous_orders['Non-CAT']) ? $old_previous_orders['Non-CAT'] : 0));

        $data['previous_day_total_revenue']['Study Abroad'] = (int) ((isset($new_previous_orders['Study Abroad']) ? $new_previous_orders['Study Abroad'] : 0) + (isset($old_previous_orders['Study Abroad']) ? $old_previous_orders['Study Abroad'] : 0));

        $data['previous_day_total_revenue']['UnderGrad'] = (int) ((isset($new_previous_orders['UnderGrad']) ? $new_previous_orders['UnderGrad'] : 0) + (isset($old_previous_orders['UnderGrad']) ? $old_previous_orders['UnderGrad'] : 0));
        // previous day total revenue end

        // Failed Order List Start
        $failed_order = DB::table('orders')
            ->selectRaw('orders.id as order_id,orders.user_id as user_id, order_items.course_id as course_id,order_items.id as order_item_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', ["$this->startDate", "$this->endDate"])
            ->whereIn('orders.payment_status', ['timeout', 'failed'])
            ->get();

        foreach ($failed_order as $order) {
            $orderDetail = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.payment_status', 'completed')
                ->where('order_items.course_id', $order->course_id)
                ->where('order_items.user_id', $order->user_id)
                ->first();
            if (!$orderDetail) {
                if (!in_array($order->order_item_id, $failedOrderItemIDs)) {
                    array_push($failedOrderItemIDs, $order->order_item_id);
                }
            } else {
                ++$failed_order_repeat_purchase;
            }
        }
        $data['failed_order_repeat_purchase'] = $failed_order_repeat_purchase;
        $data['failed_order_dont_purchase'] = count($failedOrderItemIDs);
        $data['failed_order_list'] = DB::table('orders')
        // ->selectRaw('orders.id as order_id,users.id as user_id,users.name as name,users.email as email,users.phone_number as phone_number')
            ->selectRaw('orders.id as order_id,orders.bd_name as name,orders.bd_email as email,orders.bd_phone_number as phone_number,order_items.name as course_name')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
        // ->join('users', 'users.id', '=', 'orders.user_id')
        // ->join('courses', 'courses.id', '=', 'order_items.course_id')
            ->whereIn('order_items.id', $failedOrderItemIDs)
            ->orderByDesc('orders.created_at')
            ->get();
        // Failed Order List End
        return $data;
    }

    public function getCATData()
    {
        $new_today_count = $old_today_count = $new_today_revenue = $old_today_revenue = $new_lastDay_count = $old_lastDay_count = $new_lastDay_revenue = $old_lastDay_revenue = 0;
        $new_today = $old_today = $new_lastDay = $old_lastDay = $data = [];
        $categories = DB::table('course_categories')
            ->select('id', 'name')
            ->where('name', 'CAT')
            ->first();

        foreach ($this->getNewTodayCatCourses($categories->id) as $course) {
            $new_today_count += $course->count;
            $new_today_revenue += $course->total_amount;
            $new_today['enrollment'][$course->course_slug] = $course->count;
            $new_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getNewLastDayCatCourses($categories->id) as $course) {
            $new_lastDay_count += $course->count;
            $new_lastDay_revenue += $course->total_amount;
            $new_lastDay['enrollment'][$course->course_slug] = $course->count;
            $new_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldTodayCatCourses($categories->id) as $course) {
            $old_today_count += $course->count;
            $old_today_revenue += $course->total_amount;
            $old_today['enrollment'][$course->course_slug] = $course->count;
            $old_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldLastDayCatCourses($categories->id) as $course) {
            $old_lastDay_count += $course->count;
            $old_lastDay_revenue += $course->total_amount;
            $old_lastDay['enrollment'][$course->course_slug] = $course->count;
            $old_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        $data['total_revenue']['sum'] = $new_today_revenue + $old_today_revenue;
        $lastDayTotalRevenue = ($new_lastDay_revenue + $old_lastDay_revenue) > 0 ? ($new_lastDay_revenue + $old_lastDay_revenue) : 1;
        $data['total_revenue']['per'] = min(($data['total_revenue']['sum'] - $lastDayTotalRevenue) / $lastDayTotalRevenue * 100, 100);

        $data['enrollment']['count'] = $new_today_count + $old_today_count;
        $lastDayTotalEnrollment = ($new_lastDay_count + $old_lastDay_count) > 0 ? ($new_lastDay_count + $old_lastDay_count) : 1;
        $data['enrollment']['per'] = min(($data['enrollment']['count'] - $lastDayTotalEnrollment) / $lastDayTotalEnrollment * 100, 100);

        // Today Enrollment start
        $data['today_enrollment']['cat-course'] = (isset($new_today['enrollment']['cat-course']) ? $new_today['enrollment']['cat-course'] : 0) + (isset($old_today['enrollment']['cat-course']) ? $old_today['enrollment']['cat-course'] : 0);
        $data['today_enrollment']['cat-2023-turbo-course'] = (isset($new_today['enrollment']['cat-2023-turbo-course']) ? $new_today['enrollment']['cat-2023-turbo-course'] : 0) + (isset($old_today['enrollment']['cat-2023-turbo-course']) ? $old_today['enrollment']['cat-2023-turbo-course'] : 0);
        $data['today_enrollment']['cat-2023-self-study-course'] = (isset($new_today['enrollment']['cat-2023-self-study-course']) ? $new_today['enrollment']['cat-2023-self-study-course'] : 0) + (isset($old_today['enrollment']['cat-2023-self-study-course']) ? $old_today['enrollment']['cat-2023-self-study-course'] : 0);
        $data['today_enrollment']['cat-for-repeaters'] = (isset($new_today['enrollment']['cat-for-repeaters']) ? $new_today['enrollment']['cat-for-repeaters'] : 0) + (isset($old_today['enrollment']['cat-for-repeaters']) ? $old_today['enrollment']['cat-for-repeaters'] : 0);
        $data['today_enrollment']['quants-course'] = (isset($new_today['enrollment']['quants-course']) ? $new_today['enrollment']['quants-course'] : 0) + (isset($old_today['enrollment']['quants-course']) ? $old_today['enrollment']['quants-course'] : 0);
        $data['today_enrollment']['repeaters-80-to-90'] = (isset($new_today['enrollment']['repeaters-80-to-90']) ? $new_today['enrollment']['repeaters-80-to-90'] : 0) + (isset($oldtoday['enrollment']['repeaters-80-to-90']) ? $old_today['enrollment']['repeaters-80-to-90'] : 0);
        $data['today_enrollment']['cat-for-iit-nit'] = (isset($new_today['enrollment']['cat-for-iit-nit']) ? $new_today['enrollment']['cat-for-iit-nit'] : 0) + (isset($old_today['enrollment']['cat-for-iit-nit']) ? $old_today['enrollment']['cat-for-iit-nit'] : 0);
        $data['today_enrollment']['repeaters-90-to-95'] = (isset($new_today['enrollment']['repeaters-90-to-95']) ? $new_today['enrollment']['repeaters-90-to-95'] : 0) + (isset($old_today['enrollment']['repeaters-90-to-95']) ? $old_today['enrollment']['repeaters-90-to-95'] : 0);
        $data['today_enrollment']['books-and-mocks'] = (isset($new_today['enrollment']['books-and-mocks']) ? $new_today['enrollment']['books-and-mocks'] : 0) + (isset($old_today['enrollment']['books-and-mocks']) ? $old_today['enrollment']['books-and-mocks'] : 0);
        $data['today_enrollment']['dilr-courses'] = (isset($new_today['enrollment']['dilr-courses']) ? $new_today['enrollment']['dilr-courses'] : 0) + (isset($old_today['enrollment']['dilr-courses']) ? $old_today['enrollment']['dilr-courses'] : 0);
        $data['today_enrollment']['cat-non-engineers'] = (isset($new_today['enrollment']['cat-non-engineers']) ? $new_today['enrollment']['cat-non-engineers'] : 0) + (isset($old_today['enrollment']['cat-non-engineers']) ? $old_today['enrollment']['cat-non-engineers'] : 0);
        $data['today_enrollment']['verbal-ability-course'] = (isset($new_today['enrollment']['verbal-ability-course']) ? $new_today['enrollment']['verbal-ability-course'] : 0) + (isset($old_lastDay['enrollment']['verbal-ability-course']) ? $old_today['enrollment']['verbal-ability-course'] : 0);
        $data['today_enrollment']['repeaters-80'] = (isset($new_today['enrollment']['repeaters-80']) ? $new_today['enrollment']['repeaters-80'] : 0) + (isset($old_today['enrollment']['repeaters-80']) ? $old_today['enrollment']['repeaters-80'] : 0);
        $data['today_enrollment']['cat-self-study'] = (isset($new_today['enrollment']['cat-self-study']) ? $new_today['enrollment']['cat-self-study'] : 0) + (isset($old_today['enrollment']['cat-self-study']) ? $old_today['enrollment']['cat-self-study'] : 0);
        $data['today_enrollment']['cat-turbo-2024'] = (isset($new_today['enrollment']['cat-turbo-2024']) ? $new_today['enrollment']['cat-turbo-2024'] : 0) + (isset($old_today['enrollment']['cat-turbo-2024']) ? $old_today['enrollment']['cat-turbo-2024'] : 0);
        $data['today_enrollment']['cat-intensive'] = (isset($new_today['enrollment']['cat-intensive']) ? $new_today['enrollment']['cat-intensive'] : 0) + (isset($old_today['enrollment']['cat-intensive']) ? $old_today['enrollment']['cat-intensive'] : 0);

        // $data['today_enrollment']['cat-2024-gmat-combo'] = (isset($new_today['enrollment']['cat-2024-gmat-combo']) ? $new_today['enrollment']['cat-2024-gmat-combo'] : 0) + (isset($old_today['enrollment']['cat-2024-gmat-combo']) ? $old_today['enrollment']['cat-2024-gmat-combo'] : 0);
        // Today Enrollment end

        // Today Revenue start
        $data['today_revenue']['cat-course'] = (isset($new_today['total_revenue']['cat-course']) ? $new_today['total_revenue']['cat-course'] : 0) + (isset($old_today['total_revenue']['cat-course']) ? $old_today['total_revenue']['cat-course'] : 0);
        $data['today_revenue']['cat-2023-turbo-course'] = (isset($new_today['total_revenue']['cat-2023-turbo-course']) ? $new_today['total_revenue']['cat-2023-turbo-course'] : 0) + (isset($old_today['total_revenue']['cat-2023-turbo-course']) ? $old_today['total_revenue']['cat-2023-turbo-course'] : 0);
        $data['today_revenue']['cat-2023-self-study-course'] = (isset($new_today['total_revenue']['cat-2023-self-study-course']) ? $new_today['total_revenue']['cat-2023-self-study-course'] : 0) + (isset($old_today['total_revenue']['cat-2023-self-study-course']) ? $old_today['total_revenue']['cat-2023-self-study-course'] : 0);
        $data['today_revenue']['cat-for-repeaters'] = (isset($new_today['total_revenue']['cat-for-repeaters']) ? $new_today['total_revenue']['cat-for-repeaters'] : 0) + (isset($old_today['total_revenue']['cat-for-repeaters']) ? $old_today['total_revenue']['cat-for-repeaters'] : 0);
        $data['today_revenue']['quants-course'] = (isset($new_today['total_revenue']['quants-course']) ? $new_today['total_revenue']['quants-course'] : 0) + (isset($old_today['total_revenue']['quants-course']) ? $old_today['total_revenue']['quants-course'] : 0);
        $data['today_revenue']['repeaters-80-to-90'] = (isset($new_today['total_revenue']['repeaters-80-to-90']) ? $new_today['total_revenue']['repeaters-80-to-90'] : 0) + (isset($old_today['total_revenue']['repeaters-80-to-90']) ? $old_today['total_revenue']['repeaters-80-to-90'] : 0);
        $data['today_revenue']['cat-for-iit-nit'] = (isset($new_today['total_revenue']['cat-for-iit-nit']) ? $new_today['total_revenue']['cat-for-iit-nit'] : 0) + (isset($old_today['total_revenue']['cat-for-iit-nit']) ? $old_today['total_revenue']['cat-for-iit-nit'] : 0);
        $data['today_revenue']['repeaters-90-to-95'] = (isset($new_today['total_revenue']['repeaters-90-to-95']) ? $new_today['total_revenue']['repeaters-90-to-95'] : 0) + (isset($old_today['total_revenue']['repeaters-90-to-95']) ? $old_today['total_revenue']['repeaters-90-to-95'] : 0);
        $data['today_revenue']['books-and-mocks'] = (isset($new_today['total_revenue']['books-and-mocks']) ? $new_today['total_revenue']['books-and-mocks'] : 0) + (isset($old_today['total_revenue']['books-and-mocks']) ? $old_today['total_revenue']['books-and-mocks'] : 0);
        $data['today_revenue']['dilr-courses'] = (isset($new_today['total_revenue']['dilr-courses']) ? $new_today['total_revenue']['dilr-courses'] : 0) + (isset($old_today['total_revenue']['dilr-courses']) ? $old_today['total_revenue']['dilr-courses'] : 0);
        $data['today_revenue']['cat-non-engineers'] = (isset($new_today['total_revenue']['cat-non-engineers']) ? $new_today['total_revenue']['cat-non-engineers'] : 0) + (isset($old_today['total_revenue']['cat-non-engineers']) ? $old_today['total_revenue']['cat-non-engineers'] : 0);
        $data['today_revenue']['verbal-ability-course'] = (isset($new_today['total_revenue']['verbal-ability-course']) ? $new_today['total_revenue']['verbal-ability-course'] : 0) + (isset($old_today['total_revenue']['verbal-ability-course']) ? $old_today['total_revenue']['verbal-ability-course'] : 0);
        $data['today_revenue']['repeaters-80'] = (isset($new_today['total_revenue']['repeaters-80']) ? $new_today['total_revenue']['repeaters-80'] : 0) + (isset($old_today['total_revenue']['repeaters-80']) ? $old_today['total_revenue']['repeaters-80'] : 0);
        $data['today_revenue']['cat-self-study'] = (isset($new_today['total_revenue']['cat-self-study']) ? $new_today['total_revenue']['cat-self-study'] : 0) + (isset($old_today['total_revenue']['cat-self-study']) ? $old_today['total_revenue']['cat-self-study'] : 0);
        $data['today_revenue']['cat-turbo-2024'] = (isset($new_today['total_revenue']['cat-turbo-2024']) ? $new_today['total_revenue']['cat-turbo-2024'] : 0) + (isset($old_today['total_revenue']['cat-turbo-2024']) ? $old_today['total_revenue']['cat-turbo-2024'] : 0);
        $data['today_revenue']['cat-intensive'] = (isset($new_today['total_revenue']['cat-intensive']) ? $new_today['total_revenue']['cat-intensive'] : 0) + (isset($old_today['total_revenue']['cat-intensive']) ? $old_today['total_revenue']['cat-intensive'] : 0);
        // $data['today_revenue']['cat-2024-gmat-combo'] = (isset($new_today['total_revenue']['cat-2024-gmat-combo']) ? $new_today['cat-2024-gmat-combo']['cat-intensive'] : 0) + (isset($old_today['total_revenue']['cat-2024-gmat-combo']) ? $old_today['total_revenue']['cat-2024-gmat-combo'] : 0);
        // Today Revenue end

        // Last Day Enrollment start
        $data['last_day_enrollment']['cat-course'] = (isset($new_lastDay['enrollment']['cat-course']) ? $new_lastDay['enrollment']['cat-course'] : 0) + (isset($old_lastDay['enrollment']['cat-course']) ? $old_lastDay['enrollment']['cat-course'] : 0);
        $data['last_day_enrollment']['cat-2023-turbo-course'] = (isset($new_lastDay['enrollment']['cat-2023-turbo-course']) ? $new_lastDay['enrollment']['cat-2023-turbo-course'] : 0) + (isset($old_lastDay['enrollment']['cat-2023-turbo-course']) ? $old_lastDay['enrollment']['cat-2023-turbo-course'] : 0);
        $data['last_day_enrollment']['cat-2023-self-study-course'] = (isset($new_lastDay['enrollment']['cat-2023-self-study-course']) ? $new_lastDay['enrollment']['cat-2023-self-study-course'] : 0) + (isset($old_lastDay['enrollment']['cat-2023-self-study-course']) ? $old_lastDay['enrollment']['cat-2023-self-study-course'] : 0);
        $data['last_day_enrollment']['cat-for-repeaters'] = (isset($new_lastDay['enrollment']['cat-for-repeaters']) ? $new_lastDay['enrollment']['cat-for-repeaters'] : 0) + (isset($old_lastDay['enrollment']['cat-for-repeaters']) ? $old_lastDay['enrollment']['cat-for-repeaters'] : 0);
        $data['last_day_enrollment']['quants-course'] = (isset($new_lastDay['enrollment']['quants-course']) ? $new_lastDay['enrollment']['quants-course'] : 0) + (isset($old_lastDay['enrollment']['quants-course']) ? $old_lastDay['enrollment']['quants-course'] : 0);
        $data['last_day_enrollment']['repeaters-80-to-90'] = (isset($new_lastDay['enrollment']['repeaters-80-to-90']) ? $new_lastDay['enrollment']['repeaters-80-to-90'] : 0) + (isset($old_lastDay['enrollment']['repeaters-80-to-90']) ? $old_lastDay['enrollment']['repeaters-80-to-90'] : 0);
        $data['last_day_enrollment']['cat-for-iit-nit'] = (isset($new_lastDay['enrollment']['cat-for-iit-nit']) ? $new_lastDay['enrollment']['cat-for-iit-nit'] : 0) + (isset($old_lastDay['enrollment']['cat-for-iit-nit']) ? $old_lastDay['enrollment']['cat-for-iit-nit'] : 0);
        $data['last_day_enrollment']['repeaters-90-to-95'] = (isset($new_lastDay['enrollment']['repeaters-90-to-95']) ? $new_lastDay['enrollment']['repeaters-90-to-95'] : 0) + (isset($old_lastDay['enrollment']['repeaters-90-to-95']) ? $old_lastDay['enrollment']['repeaters-90-to-95'] : 0);
        $data['last_day_enrollment']['books-and-mocks'] = (isset($new_lastDay['enrollment']['books-and-mocks']) ? $new_lastDay['enrollment']['books-and-mocks'] : 0) + (isset($old_lastDay['enrollment']['books-and-mocks']) ? $old_lastDay['enrollment']['books-and-mocks'] : 0);
        $data['last_day_enrollment']['dilr-courses'] = (isset($new_lastDay['enrollment']['dilr-courses']) ? $new_lastDay['enrollment']['dilr-courses'] : 0) + (isset($old_lastDay['enrollment']['dilr-courses']) ? $old_lastDay['enrollment']['dilr-courses'] : 0);
        $data['last_day_enrollment']['cat-non-engineers'] = (isset($new_lastDay['enrollment']['cat-non-engineers']) ? $new_lastDay['enrollment']['cat-non-engineers'] : 0) + (isset($old_lastDay['enrollment']['cat-non-engineers']) ? $old_lastDay['enrollment']['cat-non-engineers'] : 0);
        $data['last_day_enrollment']['verbal-ability-course'] = (isset($new_lastDay['enrollment']['verbal-ability-course']) ? $new_lastDay['enrollment']['verbal-ability-course'] : 0) + (isset($old_lastDay['enrollment']['verbal-ability-course']) ? $old_lastDay['enrollment']['verbal-ability-course'] : 0);
        $data['last_day_enrollment']['repeaters-80'] = (isset($new_lastDay['enrollment']['repeaters-80']) ? $new_lastDay['enrollment']['repeaters-80'] : 0) + (isset($old_lastDay['enrollment']['repeaters-80']) ? $old_lastDay['enrollment']['repeaters-80'] : 0);
        $data['last_day_enrollment']['cat-self-study'] = (isset($new_lastDay['enrollment']['cat-self-study']) ? $new_lastDay['enrollment']['cat-self-study'] : 0) + (isset($old_lastDay['enrollment']['cat-self-study']) ? $old_lastDay['enrollment']['cat-self-study'] : 0);
        $data['last_day_enrollment']['cat-turbo-2024'] = (isset($new_lastDay['enrollment']['cat-turbo-2024']) ? $new_lastDay['enrollment']['cat-turbo-2024'] : 0) + (isset($old_lastDay['enrollment']['cat-turbo-2024']) ? $old_lastDay['enrollment']['cat-turbo-2024'] : 0);
        $data['last_day_enrollment']['cat-intensive'] = (isset($new_lastDay['enrollment']['cat-intensive']) ? $new_lastDay['enrollment']['cat-intensive'] : 0) + (isset($old_lastDay['enrollment']['cat-intensive']) ? $old_lastDay['enrollment']['cat-intensive'] : 0);
        // $data['last_day_enrollment']['cat-2024-gmat-combo'] = (isset($new_lastDay['enrollment']['cat-2024-gmat-combo']) ? $new_lastDay['enrollment']['cat-2024-gmat-combo'] : 0) + (isset($old_lastDay['enrollment']['cat-2024-gmat-combo']) ? $old_lastDay['enrollment']['cat-2024-gmat-combo'] : 0);
        // Last Day Enrollment end

        // Last Day Revenue start
        $data['last_day_revenue']['cat-course'] = (isset($new_lastDay['total_revenue']['cat-course']) ? $new_lastDay['total_revenue']['cat-course'] : 0) + (isset($old_lastDay['total_revenue']['cat-course']) ? $old_lastDay['total_revenue']['cat-course'] : 0);
        $data['last_day_revenue']['cat-2023-turbo-course'] = (isset($new_lastDay['total_revenue']['cat-2023-turbo-course']) ? $new_lastDay['total_revenue']['cat-2023-turbo-course'] : 0) + (isset($old_lastDay['total_revenue']['cat-2023-turbo-course']) ? $old_lastDay['total_revenue']['cat-2023-turbo-course'] : 0);
        $data['last_day_revenue']['cat-2023-self-study-course'] = (isset($new_lastDay['total_revenue']['cat-2023-self-study-course']) ? $new_lastDay['total_revenue']['cat-2023-self-study-course'] : 0) + (isset($old_lastDay['total_revenue']['cat-2023-self-study-course']) ? $old_lastDay['total_revenue']['cat-2023-self-study-course'] : 0);
        $data['last_day_revenue']['cat-for-repeaters'] = (isset($new_lastDay['total_revenue']['cat-for-repeaters']) ? $new_lastDay['total_revenue']['cat-for-repeaters'] : 0) + (isset($old_lastDay['total_revenue']['cat-for-repeaters']) ? $old_lastDay['total_revenue']['cat-for-repeaters'] : 0);
        $data['last_day_revenue']['quants-course'] = (isset($new_lastDay['total_revenue']['quants-course']) ? $new_lastDay['total_revenue']['quants-course'] : 0) + (isset($old_lastDay['total_revenue']['quants-course']) ? $old_lastDay['total_revenue']['quants-course'] : 0);
        $data['last_day_revenue']['repeaters-80-to-90'] = (isset($new_lastDay['total_revenue']['repeaters-80-to-90']) ? $new_lastDay['total_revenue']['repeaters-80-to-90'] : 0) + (isset($old_lastDay['total_revenue']['repeaters-80-to-90']) ? $old_lastDay['total_revenue']['repeaters-80-to-90'] : 0);
        $data['last_day_revenue']['cat-for-iit-nit'] = (isset($new_lastDay['total_revenue']['cat-for-iit-nit']) ? $new_lastDay['total_revenue']['cat-for-iit-nit'] : 0) + (isset($old_lastDay['total_revenue']['cat-for-iit-nit']) ? $old_lastDay['total_revenue']['cat-for-iit-nit'] : 0);
        $data['last_day_revenue']['repeaters-90-to-95'] = (isset($new_lastDay['total_revenue']['repeaters-90-to-95']) ? $new_lastDay['total_revenue']['repeaters-90-to-95'] : 0) + (isset($old_lastDay['total_revenue']['repeaters-90-to-95']) ? $old_lastDay['total_revenue']['repeaters-90-to-95'] : 0);
        $data['last_day_revenue']['books-and-mocks'] = (isset($new_lastDay['total_revenue']['books-and-mocks']) ? $new_lastDay['total_revenue']['books-and-mocks'] : 0) + (isset($old_lastDay['total_revenue']['books-and-mocks']) ? $old_lastDay['total_revenue']['books-and-mocks'] : 0);
        $data['last_day_revenue']['dilr-courses'] = (isset($new_lastDay['total_revenue']['dilr-courses']) ? $new_lastDay['total_revenue']['dilr-courses'] : 0) + (isset($old_lastDay['total_revenue']['dilr-courses']) ? $old_lastDay['total_revenue']['dilr-courses'] : 0);
        $data['last_day_revenue']['cat-non-engineers'] = (isset($new_lastDay['total_revenue']['cat-non-engineers']) ? $new_lastDay['total_revenue']['cat-non-engineers'] : 0) + (isset($old_lastDay['total_revenue']['cat-non-engineers']) ? $old_lastDay['total_revenue']['cat-non-engineers'] : 0);
        $data['last_day_revenue']['verbal-ability-course'] = (isset($new_lastDay['total_revenue']['verbal-ability-course']) ? $new_lastDay['total_revenue']['verbal-ability-course'] : 0) + (isset($old_lastDay['total_revenue']['verbal-ability-course']) ? $old_lastDay['total_revenue']['verbal-ability-course'] : 0);
        $data['last_day_revenue']['repeaters-80'] = (isset($new_lastDay['total_revenue']['repeaters-80']) ? $new_lastDay['total_revenue']['repeaters-80'] : 0) + (isset($old_lastDay['total_revenue']['repeaters-80']) ? $old_lastDay['total_revenue']['repeaters-80'] : 0);
        $data['last_day_revenue']['cat-self-study'] = (isset($new_lastDay['total_revenue']['cat-self-study']) ? $new_lastDay['total_revenue']['cat-self-study'] : 0) + (isset($old_lastDay['total_revenue']['cat-self-study']) ? $old_lastDay['total_revenue']['cat-self-study'] : 0);
        $data['last_day_revenue']['cat-turbo-2024'] = (isset($new_lastDay['total_revenue']['cat-turbo-2024']) ? $new_lastDay['total_revenue']['cat-turbo-2024'] : 0) + (isset($old_lastDay['total_revenue']['cat-turbo-2024']) ? $old_lastDay['total_revenue']['cat-turbo-2024'] : 0);
        $data['last_day_revenue']['cat-intensive'] = (isset($new_lastDay['total_revenue']['cat-intensive']) ? $new_lastDay['total_revenue']['cat-intensive'] : 0) + (isset($old_lastDay['total_revenue']['cat-intensive']) ? $old_lastDay['total_revenue']['cat-intensive'] : 0);
        // $data['last_day_revenue']['cat-2024-gmat-combo'] = (isset($new_lastDay['total_revenue']['cat-2024-gmat-combo']) ? $new_lastDay['total_revenue']['cat-2024-gmat-combo'] : 0) + (isset($old_lastDay['total_revenue']['cat-2024-gmat-combo']) ? $old_lastDay['total_revenue']['cat-2024-gmat-combo'] : 0);
        // Last Day Revenue end

        return $data;
    }

    public function getNonCATData()
    {
        $new_today_count = $old_today_count = $new_today_revenue = $old_today_revenue = $new_lastDay_count = $old_lastDay_count = $new_lastDay_revenue = $old_lastDay_revenue = 0;
        $new_today = $old_today = $new_lastDay = $old_lastDay = $data = [];
        $categories = DB::table('course_categories')
            ->select('id', 'name')
            ->where('name', 'Non-CAT')
            ->first();

        foreach ($this->getNewTodayCatCourses($categories->id) as $course) {
            $new_today_count += $course->count;
            $new_today_revenue += $course->total_amount;
            $new_today['enrollment'][$course->course_slug] = $course->count;
            $new_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getNewLastDayCatCourses($categories->id) as $course) {
            $new_lastDay_count += $course->count;
            $new_lastDay_revenue += $course->total_amount;
            $new_lastDay['enrollment'][$course->course_slug] = $course->count;
            $new_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldTodayCatCourses($categories->id) as $course) {
            $old_today_count += $course->count;
            $old_today_revenue += $course->total_amount;
            $old_today['enrollment'][$course->course_slug] = $course->count;
            $old_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldLastDayCatCourses($categories->id) as $course) {
            $old_lastDay_count += $course->count;
            $old_lastDay_revenue += $course->total_amount;
            $old_lastDay['enrollment'][$course->course_slug] = $course->count;
            $old_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        $data['total_revenue']['sum'] = $new_today_revenue + $old_today_revenue;
        $lastDayTotalRevenue = ($new_lastDay_revenue + $old_lastDay_revenue) > 0 ? ($new_lastDay_revenue + $old_lastDay_revenue) : 1;
        $data['total_revenue']['per'] = min(($data['total_revenue']['sum'] - $lastDayTotalRevenue) / $lastDayTotalRevenue * 100, 100);

        $data['enrollment']['count'] = $new_today_count + $old_today_count;
        $lastDayTotalEnrollment = ($new_lastDay_count + $old_lastDay_count) > 0 ? ($new_lastDay_count + $old_lastDay_count) : 1;
        $data['enrollment']['per'] = min(($data['enrollment']['count'] - $lastDayTotalEnrollment) / $lastDayTotalEnrollment * 100, 100);

        // Today Enrollment start
        $data['today_enrollment']['non-cat-combo-turbo'] = (isset($new_today['enrollment']['non-cat-combo-turbo']) ? $new_today['enrollment']['non-cat-combo-turbo'] : 0) + (isset($old_today['enrollment']['non-cat-combo-turbo']) ? $old_today['enrollment']['non-cat-combo-turbo'] : 0);

        $data['today_enrollment']['srcc-gbo-mock'] = (isset($new_today['enrollment']['srcc-gbo-mock']) ? $new_today['enrollment']['srcc-gbo-mock'] : 0) + (isset($old_today['enrollment']['srcc-gbo-mock']) ? $old_today['enrollment']['srcc-gbo-mock'] : 0);

        $data['today_enrollment']['atma-turbo'] = (isset($new_today['enrollment']['atma-turbo']) ? $new_today['enrollment']['atma-turbo'] : 0) + (isset($old_today['enrollment']['atma-turbo']) ? $old_today['enrollment']['atma-turbo'] : 0);

        $data['today_enrollment']['cmat-turbo'] = (isset($new_today['enrollment']['cmat-turbo']) ? $new_today['enrollment']['cmat-turbo'] : 0) + (isset($old_today['enrollment']['cmat-turbo']) ? $old_today['enrollment']['cmat-turbo'] : 0);

        $data['today_enrollment']['gk-course'] = (isset($new_today['enrollment']['gk-course']) ? $new_today['enrollment']['gk-course'] : 0) + (isset($old_today['enrollment']['gk-course']) ? $old_today['enrollment']['gk-course'] : 0);

        $data['today_enrollment']['snap-mocks'] = (isset($new_today['enrollment']['snap-mocks']) ? $new_today['enrollment']['snap-mocks'] : 0) + (isset($old_today['enrollment']['snap-mocks']) ? $old_today['enrollment']['snap-mocks'] : 0);

        $data['today_enrollment']['nmat'] = (isset($new_today['enrollment']['nmat']) ? $new_today['enrollment']['nmat'] : 0) + (isset($oldtoday['enrollment']['nmat']) ? $old_today['enrollment']['nmat'] : 0);

        $data['today_enrollment']['non-cat-combo-intensive'] = (isset($new_today['enrollment']['non-cat-combo-intensive']) ? $new_today['enrollment']['non-cat-combo-intensive'] : 0) + (isset($old_today['enrollment']['non-cat-combo-intensive']) ? $old_today['enrollment']['non-cat-combo-intensive'] : 0);

        $data['today_enrollment']['mat-turbo'] = (isset($new_today['enrollment']['mat-turbo']) ? $new_today['enrollment']['mat-turbo'] : 0) + (isset($old_today['enrollment']['mat-turbo']) ? $old_today['enrollment']['mat-turbo'] : 0);

        $data['today_enrollment']['cet-mocks'] = (isset($new_today['enrollment']['cet-mocks']) ? $new_today['enrollment']['cet-mocks'] : 0) + (isset($old_today['enrollment']['cet-mocks']) ? $old_today['enrollment']['cet-mocks'] : 0);

        $data['today_enrollment']['mba-all-access-pass'] = (isset($new_today['enrollment']['mba-all-access-pass']) ? $new_today['enrollment']['mba-all-access-pass'] : 0) + (isset($old_today['enrollment']['mba-all-access-pass']) ? $old_today['enrollment']['mba-all-access-pass'] : 0);

        $data['today_enrollment']['snap-course'] = (isset($new_today['enrollment']['snap-course']) ? $new_today['enrollment']['snap-course'] : 0) + (isset($old_today['enrollment']['snap-course']) ? $old_today['enrollment']['snap-course'] : 0);

        $data['today_enrollment']['iift'] = (isset($new_today['enrollment']['iift']) ? $new_today['enrollment']['iift'] : 0) + (isset($old_lastDay['enrollment']['iift']) ? $old_today['enrollment']['iift'] : 0);

        $data['today_enrollment']['cet-cmat-combo'] = (isset($new_today['enrollment']['cet-cmat-combo']) ? $new_today['enrollment']['cet-cmat-combo'] : 0) + (isset($old_today['enrollment']['cet-cmat-combo']) ? $old_today['enrollment']['cet-cmat-combo'] : 0);

        $data['today_enrollment']['tissnet-turbo'] = (isset($new_today['enrollment']['tissnet-turbo']) ? $new_today['enrollment']['tissnet-turbo'] : 0) + (isset($old_today['enrollment']['tissnet-turbo']) ? $old_today['enrollment']['tissnet-turbo'] : 0);

        $data['today_enrollment']['cet-turbo'] = (isset($new_today['enrollment']['cet-turbo']) ? $new_today['enrollment']['cet-turbo'] : 0) + (isset($old_today['enrollment']['cet-turbo']) ? $old_today['enrollment']['cet-turbo'] : 0);

        $data['today_enrollment']['srcc-gbo-course'] = (isset($new_today['enrollment']['srcc-gbo-course']) ? $new_today['enrollment']['srcc-gbo-course'] : 0) + (isset($old_today['enrollment']['srcc-gbo-course']) ? $old_today['enrollment']['srcc-gbo-course'] : 0);

        $data['today_enrollment']['micat'] = (isset($new_today['enrollment']['micat']) ? $new_today['enrollment']['micat'] : 0) + (isset($old_today['enrollment']['micat']) ? $old_today['enrollment']['micat'] : 0);

        $data['today_enrollment']['xat'] = (isset($new_today['enrollment']['xat']) ? $new_today['enrollment']['xat'] : 0) + (isset($old_today['enrollment']['xat']) ? $old_today['enrollment']['xat'] : 0);
        // Today Enrollment end

        // Today Revenue start
        $data['today_revenue']['non-cat-combo-turbo'] = (isset($new_today['total_revenue']['non-cat-combo-turbo']) ? $new_today['total_revenue']['non-cat-combo-turbo'] : 0) + (isset($old_today['total_revenue']['non-cat-combo-turbo']) ? $old_today['total_revenue']['non-cat-combo-turbo'] : 0);

        $data['today_revenue']['srcc-gbo-mock'] = (isset($new_today['total_revenue']['srcc-gbo-mock']) ? $new_today['total_revenue']['srcc-gbo-mock'] : 0) + (isset($old_today['total_revenue']['srcc-gbo-mock']) ? $old_today['total_revenue']['srcc-gbo-mock'] : 0);

        $data['today_revenue']['atma-turbo'] = (isset($new_today['total_revenue']['atma-turbo']) ? $new_today['total_revenue']['atma-turbo'] : 0) + (isset($old_today['total_revenue']['atma-turbo']) ? $old_today['total_revenue']['atma-turbo'] : 0);

        $data['today_revenue']['cmat-turbo'] = (isset($new_today['total_revenue']['cmat-turbo']) ? $new_today['total_revenue']['cmat-turbo'] : 0) + (isset($old_today['total_revenue']['cmat-turbo']) ? $old_today['total_revenue']['cmat-turbo'] : 0);
        $data['today_revenue']['gk-course'] = (isset($new_today['total_revenue']['gk-course']) ? $new_today['total_revenue']['gk-course'] : 0) + (isset($old_today['total_revenue']['gk-course']) ? $old_today['total_revenue']['gk-course'] : 0);
        $data['today_revenue']['snap-mocks'] = (isset($new_today['total_revenue']['snap-mocks']) ? $new_today['total_revenue']['snap-mocks'] : 0) + (isset($old_today['total_revenue']['snap-mocks']) ? $old_today['total_revenue']['snap-mocks'] : 0);
        $data['today_revenue']['nmat'] = (isset($new_today['total_revenue']['nmat']) ? $new_today['total_revenue']['nmat'] : 0) + (isset($old_today['total_revenue']['nmat']) ? $old_today['total_revenue']['nmat'] : 0);
        $data['today_revenue']['non-cat-combo-intensive'] = (isset($new_today['total_revenue']['non-cat-combo-intensive']) ? $new_today['total_revenue']['non-cat-combo-intensive'] : 0) + (isset($old_today['total_revenue']['non-cat-combo-intensive']) ? $old_today['total_revenue']['non-cat-combo-intensive'] : 0);
        $data['today_revenue']['mat-turbo'] = (isset($new_today['total_revenue']['mat-turbo']) ? $new_today['total_revenue']['mat-turbo'] : 0) + (isset($old_today['total_revenue']['mat-turbo']) ? $old_today['total_revenue']['mat-turbo'] : 0);
        $data['today_revenue']['cet-mocks'] = (isset($new_today['total_revenue']['cet-mocks']) ? $new_today['total_revenue']['cet-mocks'] : 0) + (isset($old_today['total_revenue']['cet-mocks']) ? $old_today['total_revenue']['cet-mocks'] : 0);
        $data['today_revenue']['mba-all-access-pass'] = (isset($new_today['total_revenue']['mba-all-access-pass']) ? $new_today['total_revenue']['mba-all-access-pass'] : 0) + (isset($old_today['total_revenue']['mba-all-access-pass']) ? $old_today['total_revenue']['mba-all-access-pass'] : 0);
        $data['today_revenue']['snap-course'] = (isset($new_today['total_revenue']['snap-course']) ? $new_today['total_revenue']['snap-course'] : 0) + (isset($old_today['total_revenue']['snap-course']) ? $old_today['total_revenue']['snap-course'] : 0);
        $data['today_revenue']['iift'] = (isset($new_today['total_revenue']['iift']) ? $new_today['total_revenue']['iift'] : 0) + (isset($old_today['total_revenue']['iift']) ? $old_today['total_revenue']['iift'] : 0);
        $data['today_revenue']['cet-cmat-combo'] = (isset($new_today['total_revenue']['cet-cmat-combo']) ? $new_today['total_revenue']['cet-cmat-combo'] : 0) + (isset($old_today['total_revenue']['cet-cmat-combo']) ? $old_today['total_revenue']['cet-cmat-combo'] : 0);
        $data['today_revenue']['tissnet-turbo'] = (isset($new_today['total_revenue']['tissnet-turbo']) ? $new_today['total_revenue']['tissnet-turbo'] : 0) + (isset($old_today['total_revenue']['tissnet-turbo']) ? $old_today['total_revenue']['tissnet-turbo'] : 0);
        $data['today_revenue']['cet-turbo'] = (isset($new_today['total_revenue']['cet-turbo']) ? $new_today['total_revenue']['cet-turbo'] : 0) + (isset($old_today['total_revenue']['cet-turbo']) ? $old_today['total_revenue']['cet-turbo'] : 0);
        $data['today_revenue']['srcc-gbo-course'] = (isset($new_today['total_revenue']['srcc-gbo-course']) ? $new_today['total_revenue']['srcc-gbo-course'] : 0) + (isset($old_today['total_revenue']['srcc-gbo-course']) ? $old_today['total_revenue']['srcc-gbo-course'] : 0);
        $data['today_revenue']['micat'] = (isset($new_today['total_revenue']['micat']) ? $new_today['total_revenue']['micat'] : 0) + (isset($old_today['total_revenue']['micat']) ? $old_today['total_revenue']['micat'] : 0);
        $data['today_revenue']['xat'] = (isset($new_today['total_revenue']['xat']) ? $new_today['total_revenue']['xat'] : 0) + (isset($old_today['total_revenue']['xat']) ? $old_today['total_revenue']['xat'] : 0);
        // Today Revenue end

        // Last Day Enrollment start
        $data['last_day_enrollment']['non-cat-combo-turbo'] = (isset($new_lastDay['enrollment']['non-cat-combo-turbo']) ? $new_lastDay['enrollment']['non-cat-combo-turbo'] : 0) + (isset($old_lastDay['enrollment']['non-cat-combo-turbo']) ? $old_lastDay['enrollment']['non-cat-combo-turbo'] : 0);

        $data['last_day_enrollment']['srcc-gbo-mock'] = (isset($new_lastDay['enrollment']['srcc-gbo-mock']) ? $new_lastDay['enrollment']['srcc-gbo-mock'] : 0) + (isset($old_lastDay['enrollment']['srcc-gbo-mock']) ? $old_lastDay['enrollment']['srcc-gbo-mock'] : 0);

        $data['last_day_enrollment']['atma-turbo'] = (isset($new_lastDay['enrollment']['atma-turbo']) ? $new_lastDay['enrollment']['atma-turbo'] : 0) + (isset($old_lastDay['enrollment']['atma-turbo']) ? $old_lastDay['enrollment']['atma-turbo'] : 0);

        $data['last_day_enrollment']['cmat-turbo'] = (isset($new_lastDay['enrollment']['cmat-turbo']) ? $new_lastDay['enrollment']['cmat-turbo'] : 0) + (isset($old_lastDay['enrollment']['cmat-turbo']) ? $old_lastDay['enrollment']['cmat-turbo'] : 0);
        $data['last_day_enrollment']['gk-course'] = (isset($new_lastDay['enrollment']['gk-course']) ? $new_lastDay['enrollment']['gk-course'] : 0) + (isset($old_lastDay['enrollment']['gk-course']) ? $old_lastDay['enrollment']['gk-course'] : 0);
        $data['last_day_enrollment']['snap-mocks'] = (isset($new_lastDay['enrollment']['snap-mocks']) ? $new_lastDay['enrollment']['snap-mocks'] : 0) + (isset($old_lastDay['enrollment']['snap-mocks']) ? $old_lastDay['enrollment']['snap-mocks'] : 0);
        $data['last_day_enrollment']['nmat'] = (isset($new_lastDay['enrollment']['nmat']) ? $new_lastDay['enrollment']['nmat'] : 0) + (isset($old_lastDay['enrollment']['nmat']) ? $old_lastDay['enrollment']['nmat'] : 0);
        $data['last_day_enrollment']['non-cat-combo-intensive'] = (isset($new_lastDay['enrollment']['non-cat-combo-intensive']) ? $new_lastDay['enrollment']['non-cat-combo-intensive'] : 0) + (isset($old_lastDay['enrollment']['non-cat-combo-intensive']) ? $old_lastDay['enrollment']['non-cat-combo-intensive'] : 0);
        $data['last_day_enrollment']['mat-turbo'] = (isset($new_lastDay['enrollment']['mat-turbo']) ? $new_lastDay['enrollment']['mat-turbo'] : 0) + (isset($old_lastDay['enrollment']['mat-turbo']) ? $old_lastDay['enrollment']['mat-turbo'] : 0);
        $data['last_day_enrollment']['cet-mocks'] = (isset($new_lastDay['enrollment']['cet-mocks']) ? $new_lastDay['enrollment']['cet-mocks'] : 0) + (isset($old_lastDay['enrollment']['cet-mocks']) ? $old_lastDay['enrollment']['cet-mocks'] : 0);
        $data['last_day_enrollment']['mba-all-access-pass'] = (isset($new_lastDay['enrollment']['mba-all-access-pass']) ? $new_lastDay['enrollment']['mba-all-access-pass'] : 0) + (isset($old_lastDay['enrollment']['mba-all-access-pass']) ? $old_lastDay['enrollment']['mba-all-access-pass'] : 0);
        $data['last_day_enrollment']['snap-course'] = (isset($new_lastDay['enrollment']['snap-course']) ? $new_lastDay['enrollment']['snap-course'] : 0) + (isset($old_lastDay['enrollment']['snap-course']) ? $old_lastDay['enrollment']['snap-course'] : 0);
        $data['last_day_enrollment']['iift'] = (isset($new_lastDay['enrollment']['iift']) ? $new_lastDay['enrollment']['iift'] : 0) + (isset($old_lastDay['enrollment']['iift']) ? $old_lastDay['enrollment']['iift'] : 0);
        $data['last_day_enrollment']['cet-cmat-combo'] = (isset($new_lastDay['enrollment']['cet-cmat-combo']) ? $new_lastDay['enrollment']['cet-cmat-combo'] : 0) + (isset($old_lastDay['enrollment']['cet-cmat-combo']) ? $old_lastDay['enrollment']['cet-cmat-combo'] : 0);
        $data['last_day_enrollment']['tissnet-turbo'] = (isset($new_lastDay['enrollment']['tissnet-turbo']) ? $new_lastDay['enrollment']['tissnet-turbo'] : 0) + (isset($old_lastDay['enrollment']['tissnet-turbo']) ? $old_lastDay['enrollment']['tissnet-turbo'] : 0);
        $data['last_day_enrollment']['cet-turbo'] = (isset($new_lastDay['enrollment']['cet-turbo']) ? $new_lastDay['enrollment']['cet-turbo'] : 0) + (isset($old_lastDay['enrollment']['cet-turbo']) ? $old_lastDay['enrollment']['cet-turbo'] : 0);
        $data['last_day_enrollment']['srcc-gbo-course'] = (isset($new_lastDay['enrollment']['srcc-gbo-course']) ? $new_lastDay['enrollment']['srcc-gbo-course'] : 0) + (isset($old_lastDay['enrollment']['srcc-gbo-course']) ? $old_lastDay['enrollment']['srcc-gbo-course'] : 0);
        $data['last_day_enrollment']['micat'] = (isset($new_lastDay['enrollment']['micat']) ? $new_lastDay['enrollment']['micat'] : 0) + (isset($old_lastDay['enrollment']['micat']) ? $old_lastDay['enrollment']['micat'] : 0);
        $data['last_day_enrollment']['xat'] = (isset($new_lastDay['enrollment']['xat']) ? $new_lastDay['enrollment']['xat'] : 0) + (isset($old_lastDay['enrollment']['xat']) ? $old_lastDay['enrollment']['xat'] : 0);
        // Last Day Enrollment end

        // Last Day Revenue start
        $data['last_day_revenue']['non-cat-combo-turbo'] = (isset($new_lastDay['total_revenue']['non-cat-combo-turbo']) ? $new_lastDay['total_revenue']['non-cat-combo-turbo'] : 0) + (isset($old_lastDay['total_revenue']['non-cat-combo-turbo']) ? $old_lastDay['total_revenue']['non-cat-combo-turbo'] : 0);

        $data['last_day_revenue']['srcc-gbo-mock'] = (isset($new_lastDay['total_revenue']['srcc-gbo-mock']) ? $new_lastDay['total_revenue']['srcc-gbo-mock'] : 0) + (isset($old_lastDay['total_revenue']['srcc-gbo-mock']) ? $old_lastDay['total_revenue']['srcc-gbo-mock'] : 0);

        $data['last_day_revenue']['atma-turbo'] = (isset($new_lastDay['total_revenue']['atma-turbo']) ? $new_lastDay['total_revenue']['atma-turbo'] : 0) + (isset($old_lastDay['total_revenue']['atma-turbo']) ? $old_lastDay['total_revenue']['atma-turbo'] : 0);

        $data['last_day_revenue']['cmat-turbo'] = (isset($new_lastDay['total_revenue']['cmat-turbo']) ? $new_lastDay['total_revenue']['cmat-turbo'] : 0) + (isset($old_lastDay['total_revenue']['cmat-turbo']) ? $old_lastDay['total_revenue']['cmat-turbo'] : 0);
        $data['last_day_revenue']['gk-course'] = (isset($new_lastDay['total_revenue']['gk-course']) ? $new_lastDay['total_revenue']['gk-course'] : 0) + (isset($old_lastDay['total_revenue']['gk-course']) ? $old_lastDay['total_revenue']['gk-course'] : 0);
        $data['last_day_revenue']['snap-mocks'] = (isset($new_lastDay['total_revenue']['snap-mocks']) ? $new_lastDay['total_revenue']['snap-mocks'] : 0) + (isset($old_lastDay['total_revenue']['snap-mocks']) ? $old_lastDay['total_revenue']['snap-mocks'] : 0);
        $data['last_day_revenue']['nmat'] = (isset($new_lastDay['total_revenue']['nmat']) ? $new_lastDay['total_revenue']['nmat'] : 0) + (isset($old_lastDay['total_revenue']['nmat']) ? $old_lastDay['total_revenue']['nmat'] : 0);
        $data['last_day_revenue']['non-cat-combo-intensive'] = (isset($new_lastDay['total_revenue']['non-cat-combo-intensive']) ? $new_lastDay['total_revenue']['non-cat-combo-intensive'] : 0) + (isset($old_lastDay['total_revenue']['non-cat-combo-intensive']) ? $old_lastDay['total_revenue']['non-cat-combo-intensive'] : 0);
        $data['last_day_revenue']['mat-turbo'] = (isset($new_lastDay['total_revenue']['mat-turbo']) ? $new_lastDay['total_revenue']['mat-turbo'] : 0) + (isset($old_lastDay['total_revenue']['mat-turbo']) ? $old_lastDay['total_revenue']['mat-turbo'] : 0);
        $data['last_day_revenue']['cet-mocks'] = (isset($new_lastDay['total_revenue']['cet-mocks']) ? $new_lastDay['total_revenue']['cet-mocks'] : 0) + (isset($old_lastDay['total_revenue']['cet-mocks']) ? $old_lastDay['total_revenue']['cet-mocks'] : 0);
        $data['last_day_revenue']['mba-all-access-pass'] = (isset($new_lastDay['total_revenue']['mba-all-access-pass']) ? $new_lastDay['total_revenue']['mba-all-access-pass'] : 0) + (isset($old_lastDay['total_revenue']['mba-all-access-pass']) ? $old_lastDay['total_revenue']['mba-all-access-pass'] : 0);
        $data['last_day_revenue']['snap-course'] = (isset($new_lastDay['total_revenue']['snap-course']) ? $new_lastDay['total_revenue']['snap-course'] : 0) + (isset($old_lastDay['total_revenue']['snap-course']) ? $old_lastDay['total_revenue']['snap-course'] : 0);
        $data['last_day_revenue']['iift'] = (isset($new_lastDay['total_revenue']['iift']) ? $new_lastDay['total_revenue']['iift'] : 0) + (isset($old_lastDay['total_revenue']['iift']) ? $old_lastDay['total_revenue']['iift'] : 0);
        $data['last_day_revenue']['cet-cmat-combo'] = (isset($new_lastDay['total_revenue']['cet-cmat-combo']) ? $new_lastDay['total_revenue']['cet-cmat-combo'] : 0) + (isset($old_lastDay['total_revenue']['cet-cmat-combo']) ? $old_lastDay['total_revenue']['cet-cmat-combo'] : 0);
        $data['last_day_revenue']['tissnet-turbo'] = (isset($new_lastDay['total_revenue']['tissnet-turbo']) ? $new_lastDay['total_revenue']['tissnet-turbo'] : 0) + (isset($old_lastDay['total_revenue']['tissnet-turbo']) ? $old_lastDay['total_revenue']['tissnet-turbo'] : 0);
        $data['last_day_revenue']['cet-turbo'] = (isset($new_lastDay['total_revenue']['cet-turbo']) ? $new_lastDay['total_revenue']['cet-turbo'] : 0) + (isset($old_lastDay['total_revenue']['cet-turbo']) ? $old_lastDay['total_revenue']['cet-turbo'] : 0);
        $data['last_day_revenue']['srcc-gbo-course'] = (isset($new_lastDay['total_revenue']['srcc-gbo-course']) ? $new_lastDay['total_revenue']['srcc-gbo-course'] : 0) + (isset($old_lastDay['total_revenue']['srcc-gbo-course']) ? $old_lastDay['total_revenue']['srcc-gbo-course'] : 0);
        $data['last_day_revenue']['micat'] = (isset($new_lastDay['total_revenue']['micat']) ? $new_lastDay['total_revenue']['micat'] : 0) + (isset($old_lastDay['total_revenue']['micat']) ? $old_lastDay['total_revenue']['micat'] : 0);
        $data['last_day_revenue']['xat'] = (isset($new_lastDay['total_revenue']['xat']) ? $new_lastDay['total_revenue']['xat'] : 0) + (isset($old_lastDay['total_revenue']['xat']) ? $old_lastDay['total_revenue']['xat'] : 0);
        // Last Day Revenue end

        return $data;
    }

    public function getStudyAbroadData()
    {
        $new_today_count = $old_today_count = $new_today_revenue = $old_today_revenue = $new_lastDay_count = $old_lastDay_count = $new_lastDay_revenue = $old_lastDay_revenue = 0;
        $new_today = $old_today = $new_lastDay = $old_lastDay = $data = [];
        $categories = DB::table('course_categories')
            ->select('id', 'name')
            ->where('name', 'Study Abroad')
            ->first();

        foreach ($this->getNewTodayCatCourses($categories->id) as $course) {
            $new_today_count += $course->count;
            $new_today_revenue += $course->total_amount;
            $new_today['enrollment'][$course->course_slug] = $course->count;
            $new_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getNewLastDayCatCourses($categories->id) as $course) {
            $new_lastDay_count += $course->count;
            $new_lastDay_revenue += $course->total_amount;
            $new_lastDay['enrollment'][$course->course_slug] = $course->count;
            $new_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldTodayCatCourses($categories->id) as $course) {
            $old_today_count += $course->count;
            $old_today_revenue += $course->total_amount;
            $old_today['enrollment'][$course->course_slug] = $course->count;
            $old_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldLastDayCatCourses($categories->id) as $course) {
            $old_lastDay_count += $course->count;
            $old_lastDay_revenue += $course->total_amount;
            $old_lastDay['enrollment'][$course->course_slug] = $course->count;
            $old_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        $data['total_revenue']['sum'] = $new_today_revenue + $old_today_revenue;
        $lastDayTotalRevenue = ($new_lastDay_revenue + $old_lastDay_revenue) > 0 ? ($new_lastDay_revenue + $old_lastDay_revenue) : 1;
        $data['total_revenue']['per'] = min(($data['total_revenue']['sum'] - $lastDayTotalRevenue) / $lastDayTotalRevenue * 100, 100);

        $data['enrollment']['count'] = $new_today_count + $old_today_count;
        $lastDayTotalEnrollment = ($new_lastDay_count + $old_lastDay_count) > 0 ? ($new_lastDay_count + $old_lastDay_count) : 1;
        $data['enrollment']['per'] = min(($data['enrollment']['count'] - $lastDayTotalEnrollment) / $lastDayTotalEnrollment * 100, 100);

        // Today Enrollment start
        $data['today_enrollment']['ielts-general-intensive'] = (isset($new_today['enrollment']['ielts-general-intensive']) ? $new_today['enrollment']['ielts-general-intensive'] : 0) + (isset($old_today['enrollment']['ielts-general-intensive']) ? $old_today['enrollment']['ielts-general-intensive'] : 0);

        $data['today_enrollment']['ielts-general-turbo'] = (isset($new_today['enrollment']['ielts-general-turbo']) ? $new_today['enrollment']['ielts-general-turbo'] : 0) + (isset($old_today['enrollment']['ielts-general-turbo']) ? $old_today['enrollment']['ielts-general-turbo'] : 0);

        $data['today_enrollment']['ielts-specialized-course'] = (isset($new_today['enrollment']['ielts-specialized-course']) ? $new_today['enrollment']['ielts-specialized-course'] : 0) + (isset($old_today['enrollment']['ielts-specialized-course']) ? $old_today['enrollment']['ielts-specialized-course'] : 0);

        $data['today_enrollment']['cat-gre'] = (isset($new_today['enrollment']['cat-gre']) ? $new_today['enrollment']['cat-gre'] : 0) + (isset($old_today['enrollment']['cat-gre']) ? $old_today['enrollment']['cat-gre'] : 0);

        $data['today_enrollment']['cat-gmat'] = (isset($new_today['enrollment']['cat-gmat']) ? $new_today['enrollment']['cat-gmat'] : 0) + (isset($old_today['enrollment']['cat-gmat']) ? $old_today['enrollment']['cat-gmat'] : 0);

        $data['today_enrollment']['cat-gmat-applications'] = (isset($new_today['enrollment']['cat-gmat-applications']) ? $new_today['enrollment']['cat-gmat-applications'] : 0) + (isset($old_today['enrollment']['cat-gmat-applications']) ? $old_today['enrollment']['cat-gmat-applications'] : 0);

        $data['today_enrollment']['gmat-course'] = (isset($new_today['enrollment']['gmat-course']) ? $new_today['enrollment']['gmat-course'] : 0) + (isset($old_today['enrollment']['gmat-course']) ? $old_today['enrollment']['gmat-course'] : 0);

        $data['today_enrollment']['ielts-courses'] = (isset($new_today['enrollment']['ielts-courses']) ? $new_today['enrollment']['ielts-courses'] : 0) + (isset($old_today['enrollment']['ielts-courses']) ? $old_today['enrollment']['ielts-courses'] : 0);

        $data['today_enrollment']['gre-course'] = (isset($new_today['enrollment']['gre-course']) ? $new_today['enrollment']['gre-course'] : 0) + (isset($oldtoday['enrollment']['gre-course']) ? $old_today['enrollment']['gre-course'] : 0);

        $data['today_enrollment']['ielts-course'] = (isset($new_today['enrollment']['ielts-course']) ? $new_today['enrollment']['ielts-course'] : 0) + (isset($oldtoday['enrollment']['ielts-course']) ? $old_today['enrollment']['ielts-course'] : 0);

        $data['today_enrollment']['cat-2024-gmat-combo'] = (isset($new_today['enrollment']['cat-2024-gmat-combo']) ? $new_today['enrollment']['cat-2024-gmat-combo'] : 0) + (isset($oldtoday['enrollment']['cat-2024-gmat-combo']) ? $old_today['enrollment']['cat-2024-gmat-combo'] : 0);

        $data['today_enrollment']['ielts-applications'] = (isset($new_today['enrollment']['ielts-applications']) ? $new_today['enrollment']['ielts-applications'] : 0) + (isset($oldtoday['enrollment']['ielts-applications']) ? $old_today['enrollment']['ielts-applications'] : 0);

        $data['today_enrollment']['gmat-courses'] = (isset($new_today['enrollment']['gmat-courses']) ? $new_today['enrollment']['gmat-courses'] : 0) + (isset($oldtoday['enrollment']['gmat-courses']) ? $old_today['enrollment']['gmat-courses'] : 0);

        $data['today_enrollment']['gmat-ielts-application'] = (isset($new_today['enrollment']['gmat-ielts-application']) ? $new_today['enrollment']['gmat-ielts-application'] : 0) + (isset($oldtoday['enrollment']['gmat-ielts-application']) ? $old_today['enrollment']['gmat-ielts-application'] : 0);

        $data['today_enrollment']['gre-courses'] = (isset($new_today['enrollment']['gre-courses']) ? $new_today['enrollment']['gre-courses'] : 0) + (isset($oldtoday['enrollment']['gre-courses']) ? $old_today['enrollment']['gre-courses'] : 0);
        // Today Enrollment end

        // Today Revenue start
        $data['today_revenue']['ielts-general-intensive'] = (isset($new_today['total_revenue']['ielts-general-intensive']) ? $new_today['total_revenue']['ielts-general-intensive'] : 0) + (isset($old_today['total_revenue']['ielts-general-intensive']) ? $old_today['total_revenue']['ielts-general-intensive'] : 0);

        $data['today_revenue']['ielts-general-turbo'] = (isset($new_today['total_revenue']['ielts-general-turbo']) ? $new_today['total_revenue']['ielts-general-turbo'] : 0) + (isset($old_today['total_revenue']['ielts-general-turbo']) ? $old_today['total_revenue']['ielts-general-turbo'] : 0);

        $data['today_revenue']['ielts-specialized-course'] = (isset($new_today['total_revenue']['ielts-specialized-course']) ? $new_today['total_revenue']['ielts-specialized-course'] : 0) + (isset($old_today['total_revenue']['ielts-specialized-course']) ? $old_today['total_revenue']['ielts-specialized-course'] : 0);

        $data['today_revenue']['cat-gre'] = (isset($new_today['total_revenue']['cat-gre']) ? $new_today['total_revenue']['cat-gre'] : 0) + (isset($old_today['enrollment']['cat-gre']) ? $old_today['enrollment']['cat-gre'] : 0);

        $data['today_revenue']['cat-gmat'] = (isset($new_today['total_revenue']['cat-gmat']) ? $new_today['total_revenue']['cat-gmat'] : 0) + (isset($old_today['total_revenue']['cat-gmat']) ? $old_today['total_revenue']['cat-gmat'] : 0);

        $data['today_revenue']['cat-gmat-applications'] = (isset($new_today['total_revenue']['cat-gmat-applications']) ? $new_today['total_revenue']['cat-gmat-applications'] : 0) + (isset($old_today['total_revenue']['cat-gmat-applications']) ? $old_today['total_revenue']['cat-gmat-applications'] : 0);
        $data['today_revenue']['gmat-course'] = (isset($new_today['total_revenue']['gmat-course']) ? $new_today['total_revenue']['gmat-course'] : 0) + (isset($old_today['total_revenue']['gmat-course']) ? $old_today['total_revenue']['gmat-course'] : 0);
        $data['today_revenue']['ielts-courses'] = (isset($new_today['total_revenue']['ielts-courses']) ? $new_today['total_revenue']['ielts-courses'] : 0) + (isset($old_today['total_revenue']['ielts-courses']) ? $old_today['total_revenue']['ielts-courses'] : 0);
        $data['today_revenue']['gre-course'] = (isset($new_today['total_revenue']['gre-course']) ? $new_today['total_revenue']['gre-course'] : 0) + (isset($old_today['total_revenue']['gre-course']) ? $old_today['total_revenue']['gre-course'] : 0);

        $data['today_revenue']['ielts-course'] = (isset($new_today['total_revenue']['ielts-course']) ? $new_today['total_revenue']['ielts-course'] : 0) + (isset($old_today['total_revenue']['ielts-course']) ? $old_today['total_revenue']['ielts-course'] : 0);

        $data['today_revenue']['cat-2024-gmat-combo'] = (isset($new_today['total_revenue']['cat-2024-gmat-combo']) ? $new_today['total_revenue']['cat-2024-gmat-combo'] : 0) + (isset($old_today['total_revenue']['cat-2024-gmat-combo']) ? $old_today['total_revenue']['cat-2024-gmat-combo'] : 0);

        $data['today_revenue']['ielts-applications'] = (isset($new_today['total_revenue']['ielts-applications']) ? $new_today['total_revenue']['ielts-applications'] : 0) + (isset($old_today['total_revenue']['ielts-applications']) ? $old_today['total_revenue']['ielts-applications'] : 0);

        $data['today_revenue']['gmat-courses'] = (isset($new_today['total_revenue']['gmat-courses']) ? $new_today['total_revenue']['gmat-courses'] : 0) + (isset($old_today['total_revenue']['gmat-courses']) ? $old_today['total_revenue']['gmat-courses'] : 0);

        $data['today_revenue']['gmat-ielts-application'] = (isset($new_today['total_revenue']['gmat-ielts-application']) ? $new_today['total_revenue']['gmat-ielts-application'] : 0) + (isset($old_today['total_revenue']['gmat-ielts-application']) ? $old_today['total_revenue']['gmat-ielts-application'] : 0);

        $data['today_revenue']['gre-courses'] = (isset($new_today['total_revenue']['gre-courses']) ? $new_today['total_revenue']['gre-courses'] : 0) + (isset($old_today['total_revenue']['gre-courses']) ? $old_today['total_revenue']['gre-courses'] : 0);
        // Today Revenue end

        // Last Day Enrollment start
        $data['last_day_enrollment']['ielts-general-intensive'] = (isset($new_lastDay['enrollment']['ielts-general-intensive']) ? $new_lastDay['enrollment']['ielts-general-intensive'] : 0) + (isset($old_lastDay['enrollment']['ielts-general-intensive']) ? $old_lastDay['enrollment']['ielts-general-intensive'] : 0);

        $data['last_day_enrollment']['ielts-general-turbo'] = (isset($new_lastDay['enrollment']['ielts-general-turbo']) ? $new_lastDay['enrollment']['ielts-general-turbo'] : 0) + (isset($old_lastDay['enrollment']['ielts-general-turbo']) ? $old_lastDay['enrollment']['ielts-general-turbo'] : 0);

        $data['last_day_enrollment']['ielts-specialized-course'] = (isset($new_lastDay['enrollment']['ielts-specialized-course']) ? $new_lastDay['enrollment']['ielts-specialized-course'] : 0) + (isset($old_lastDay['enrollment']['ielts-specialized-course']) ? $old_lastDay['enrollment']['ielts-specialized-course'] : 0);

        $data['last_day_enrollment']['cat-gre'] = (isset($new_lastDay['enrollment']['cat-gre']) ? $new_lastDay['enrollment']['cat-gre'] : 0) + (isset($old_lastDay['enrollment']['cat-gre']) ? $old_lastDay['enrollment']['cat-gre'] : 0);

        $data['last_day_enrollment']['cat-gmat'] = (isset($new_lastDay['enrollment']['cat-gmat']) ? $new_lastDay['enrollment']['cat-gmat'] : 0) + (isset($old_lastDay['enrollment']['cat-gmat']) ? $old_lastDay['enrollment']['cat-gmat'] : 0);

        $data['last_day_enrollment']['cat-gmat-applications'] = (isset($new_lastDay['enrollment']['cat-gmat-applications']) ? $new_lastDay['enrollment']['cat-gmat-applications'] : 0) + (isset($old_lastDay['enrollment']['cat-gmat-applications']) ? $old_lastDay['enrollment']['cat-gmat-applications'] : 0);

        $data['last_day_enrollment']['gmat-course'] = (isset($new_lastDay['enrollment']['gmat-course']) ? $new_lastDay['enrollment']['gmat-course'] : 0) + (isset($old_lastDay['enrollment']['gmat-course']) ? $old_lastDay['enrollment']['gmat-course'] : 0);

        $data['last_day_enrollment']['ielts-courses'] = (isset($new_lastDay['enrollment']['ielts-courses']) ? $new_lastDay['enrollment']['ielts-courses'] : 0) + (isset($old_lastDay['enrollment']['ielts-courses']) ? $old_lastDay['enrollment']['ielts-courses'] : 0);

        $data['last_day_enrollment']['gre-course'] = (isset($new_lastDay['enrollment']['gre-course']) ? $new_lastDay['enrollment']['gre-course'] : 0) + (isset($old_lastDay['enrollment']['gre-course']) ? $old_lastDay['enrollment']['gre-course'] : 0);

        $data['last_day_enrollment']['ielts-course'] = (isset($new_lastDay['enrollment']['ielts-course']) ? $new_lastDay['enrollment']['ielts-course'] : 0) + (isset($old_lastDay['enrollment']['ielts-course']) ? $old_lastDay['enrollment']['ielts-course'] : 0);

        $data['last_day_enrollment']['cat-2024-gmat-combo'] = (isset($new_lastDay['enrollment']['cat-2024-gmat-combo']) ? $new_lastDay['enrollment']['cat-2024-gmat-combo'] : 0) + (isset($old_lastDay['enrollment']['cat-2024-gmat-combo']) ? $old_lastDay['enrollment']['cat-2024-gmat-combo'] : 0);

        $data['last_day_enrollment']['ielts-applications'] = (isset($new_lastDay['enrollment']['ielts-applications']) ? $new_lastDay['enrollment']['ielts-applications'] : 0) + (isset($old_lastDay['enrollment']['ielts-applications']) ? $old_lastDay['enrollment']['ielts-applications'] : 0);

        $data['last_day_enrollment']['gmat-courses'] = (isset($new_lastDay['enrollment']['gmat-courses']) ? $new_lastDay['enrollment']['gmat-courses'] : 0) + (isset($old_lastDay['enrollment']['gmat-courses']) ? $old_lastDay['enrollment']['gmat-courses'] : 0);

        $data['last_day_enrollment']['gmat-ielts-application'] = (isset($new_lastDay['enrollment']['gmat-ielts-application']) ? $new_lastDay['enrollment']['gmat-ielts-application'] : 0) + (isset($old_lastDay['enrollment']['gmat-ielts-application']) ? $old_lastDay['enrollment']['gmat-ielts-application'] : 0);

        $data['last_day_enrollment']['gre-courses'] = (isset($new_lastDay['enrollment']['gre-courses']) ? $new_lastDay['enrollment']['gre-courses'] : 0) + (isset($old_lastDay['enrollment']['gre-courses']) ? $old_lastDay['enrollment']['gre-courses'] : 0);
        // Last Day Enrollment end

        // Last Day Revenue start
        $data['last_day_revenue']['ielts-general-intensive'] = (isset($new_lastDay['total_revenue']['ielts-general-intensive']) ? $new_lastDay['total_revenue']['ielts-general-intensive'] : 0) + (isset($old_lastDay['total_revenue']['ielts-general-intensive']) ? $old_lastDay['total_revenue']['ielts-general-intensive'] : 0);

        $data['last_day_revenue']['ielts-general-turbo'] = (isset($new_lastDay['total_revenue']['ielts-general-turbo']) ? $new_lastDay['total_revenue']['ielts-general-turbo'] : 0) + (isset($old_lastDay['total_revenue']['ielts-general-turbo']) ? $old_lastDay['total_revenue']['ielts-general-turbo'] : 0);

        $data['last_day_revenue']['ielts-specialized-course'] = (isset($new_lastDay['total_revenue']['ielts-specialized-course']) ? $new_lastDay['total_revenue']['ielts-specialized-course'] : 0) + (isset($old_lastDay['total_revenue']['ielts-specialized-course']) ? $old_lastDay['total_revenue']['ielts-specialized-course'] : 0);

        $data['last_day_revenue']['cat-gre'] = (isset($new_lastDay['total_revenue']['cat-gre']) ? $new_lastDay['total_revenue']['cat-gre'] : 0) + (isset($old_lastDay['enrollment']['cat-gre']) ? $old_lastDay['enrollment']['cat-gre'] : 0);

        $data['last_day_revenue']['cat-gmat'] = (isset($new_lastDay['total_revenue']['cat-gmat']) ? $new_lastDay['total_revenue']['cat-gmat'] : 0) + (isset($old_lastDay['total_revenue']['cat-gmat']) ? $old_lastDay['total_revenue']['cat-gmat'] : 0);

        $data['last_day_revenue']['cat-gmat-applications'] = (isset($new_lastDay['total_revenue']['cat-gmat-applications']) ? $new_lastDay['total_revenue']['cat-gmat-applications'] : 0) + (isset($old_lastDay['total_revenue']['cat-gmat-applications']) ? $old_lastDay['total_revenue']['cat-gmat-applications'] : 0);

        $data['last_day_revenue']['gmat-course'] = (isset($new_lastDay['total_revenue']['gmat-course']) ? $new_lastDay['total_revenue']['gmat-course'] : 0) + (isset($old_lastDay['total_revenue']['gmat-course']) ? $old_lastDay['total_revenue']['gmat-course'] : 0);

        $data['last_day_revenue']['ielts-courses'] = (isset($new_lastDay['total_revenue']['ielts-courses']) ? $new_lastDay['total_revenue']['ielts-courses'] : 0) + (isset($old_lastDay['total_revenue']['ielts-courses']) ? $old_lastDay['total_revenue']['ielts-courses'] : 0);

        $data['last_day_revenue']['gre-course'] = (isset($new_lastDay['total_revenue']['gre-course']) ? $new_lastDay['total_revenue']['gre-course'] : 0) + (isset($old_lastDay['total_revenue']['gre-course']) ? $old_lastDay['total_revenue']['gre-course'] : 0);

        $data['last_day_revenue']['ielts-course'] = (isset($new_lastDay['total_revenue']['ielts-course']) ? $new_lastDay['total_revenue']['ielts-course'] : 0) + (isset($old_lastDay['total_revenue']['ielts-course']) ? $old_lastDay['total_revenue']['ielts-course'] : 0);

        $data['last_day_revenue']['cat-2024-gmat-combo'] = (isset($new_lastDay['total_revenue']['cat-2024-gmat-combo']) ? $new_lastDay['total_revenue']['cat-2024-gmat-combo'] : 0) + (isset($old_lastDay['total_revenue']['cat-2024-gmat-combo']) ? $old_lastDay['total_revenue']['cat-2024-gmat-combo'] : 0);

        $data['last_day_revenue']['ielts-applications'] = (isset($new_lastDay['total_revenue']['ielts-applications']) ? $new_lastDay['total_revenue']['ielts-applications'] : 0) + (isset($old_lastDay['total_revenue']['ielts-applications']) ? $old_lastDay['total_revenue']['ielts-applications'] : 0);

        $data['last_day_revenue']['gmat-courses'] = (isset($new_lastDay['total_revenue']['gmat-courses']) ? $new_lastDay['total_revenue']['gmat-courses'] : 0) + (isset($old_lastDay['total_revenue']['gmat-courses']) ? $old_lastDay['total_revenue']['gmat-courses'] : 0);

        $data['last_day_revenue']['gmat-ielts-application'] = (isset($new_lastDay['total_revenue']['gmat-ielts-application']) ? $new_lastDay['total_revenue']['gmat-ielts-application'] : 0) + (isset($old_lastDay['total_revenue']['gmat-ielts-application']) ? $old_lastDay['total_revenue']['gmat-ielts-application'] : 0);

        $data['last_day_revenue']['gre-courses'] = (isset($new_lastDay['total_revenue']['gre-courses']) ? $new_lastDay['total_revenue']['gre-courses'] : 0) + (isset($old_lastDay['total_revenue']['gre-courses']) ? $old_lastDay['total_revenue']['gre-courses'] : 0);
        // Last Day Revenue end

        return $data;
    }

    public function getUnderGradData()
    {
        $new_today_count = $old_today_count = $new_today_revenue = $old_today_revenue = $new_lastDay_count = $old_lastDay_count = $new_lastDay_revenue = $old_lastDay_revenue = 0;
        $new_today = $old_today = $new_lastDay = $old_lastDay = $data = [];
        $categories = DB::table('course_categories')
            ->select('id', 'name')
            ->where('name', 'UnderGrad')
            ->first();

        foreach ($this->getNewTodayCatCourses($categories->id) as $course) {
            $new_today_count += $course->count;
            $new_today_revenue += $course->total_amount;
            $new_today['enrollment'][$course->course_slug] = $course->count;
            $new_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getNewLastDayCatCourses($categories->id) as $course) {
            $new_lastDay_count += $course->count;
            $new_lastDay_revenue += $course->total_amount;
            $new_lastDay['enrollment'][$course->course_slug] = $course->count;
            $new_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldTodayCatCourses($categories->id) as $course) {
            $old_today_count += $course->count;
            $old_today_revenue += $course->total_amount;
            $old_today['enrollment'][$course->course_slug] = $course->count;
            $old_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldLastDayCatCourses($categories->id) as $course) {
            $old_lastDay_count += $course->count;
            $old_lastDay_revenue += $course->total_amount;
            $old_lastDay['enrollment'][$course->course_slug] = $course->count;
            $old_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        $data['total_revenue']['sum'] = $new_today_revenue + $old_today_revenue;
        $lastDayTotalRevenue = ($new_lastDay_revenue + $old_lastDay_revenue) > 0 ? ($new_lastDay_revenue + $old_lastDay_revenue) : 1;
        $data['total_revenue']['per'] = min(($data['total_revenue']['sum'] - $lastDayTotalRevenue) / $lastDayTotalRevenue * 100, 100);

        $data['enrollment']['count'] = $new_today_count + $old_today_count;
        $lastDayTotalEnrollment = ($new_lastDay_count + $old_lastDay_count) > 0 ? ($new_lastDay_count + $old_lastDay_count) : 1;
        $data['enrollment']['per'] = min(($data['enrollment']['count'] - $lastDayTotalEnrollment) / $lastDayTotalEnrollment * 100, 100);

        // Today Enrollment start
        $data['today_enrollment']['ipmat-course'] = (isset($new_today['enrollment']['ipmat-course']) ? $new_today['enrollment']['ipmat-course'] : 0) + (isset($old_today['enrollment']['ipmat-course']) ? $old_today['enrollment']['ipmat-course'] : 0);

        $data['today_enrollment']['npat-course'] = (isset($new_today['enrollment']['npat-course']) ? $new_today['enrollment']['npat-course'] : 0) + (isset($old_today['enrollment']['npat-course']) ? $old_today['enrollment']['npat-course'] : 0);

        $data['today_enrollment']['cuet-courses'] = (isset($new_today['enrollment']['cuet-courses']) ? $new_today['enrollment']['cuet-courses'] : 0) + (isset($old_today['enrollment']['cuet-courses']) ? $old_today['enrollment']['cuet-courses'] : 0);
        // Today Enrollment end

        // Today Revenue start
        $data['today_revenue']['ipmat-course'] = (isset($new_today['total_revenue']['ipmat-course']) ? $new_today['total_revenue']['ipmat-course'] : 0) + (isset($old_today['total_revenue']['ipmat-course']) ? $old_today['total_revenue']['ipmat-course'] : 0);

        $data['today_revenue']['npat-course'] = (isset($new_today['total_revenue']['npat-course']) ? $new_today['total_revenue']['npat-course'] : 0) + (isset($old_today['total_revenue']['npat-course']) ? $old_today['total_revenue']['npat-course'] : 0);

        $data['today_revenue']['cuet-courses'] = (isset($new_today['total_revenue']['cuet-courses']) ? $new_today['total_revenue']['cuet-courses'] : 0) + (isset($old_today['total_revenue']['cuet-courses']) ? $old_today['total_revenue']['cuet-courses'] : 0);
        // Today Revenue end

        // Last Day Enrollment start
        $data['last_day_enrollment']['ipmat-course'] = (isset($new_lastDay['enrollment']['ipmat-course']) ? $new_lastDay['enrollment']['ipmat-course'] : 0) + (isset($old_lastDay['enrollment']['ipmat-course']) ? $old_lastDay['enrollment']['ipmat-course'] : 0);

        $data['last_day_enrollment']['npat-course'] = (isset($new_lastDay['enrollment']['npat-course']) ? $new_lastDay['enrollment']['npat-course'] : 0) + (isset($old_lastDay['enrollment']['npat-course']) ? $old_lastDay['enrollment']['npat-course'] : 0);

        $data['last_day_enrollment']['cuet-courses'] = (isset($new_lastDay['enrollment']['cuet-courses']) ? $new_lastDay['enrollment']['cuet-courses'] : 0) + (isset($old_lastDay['enrollment']['cuet-courses']) ? $old_lastDay['enrollment']['cuet-courses'] : 0);
        // Last Day Enrollment end

        // Last Day Revenue start
        $data['last_day_revenue']['ipmat-course'] = (isset($new_lastDay['total_revenue']['ipmat-course']) ? $new_lastDay['total_revenue']['ipmat-course'] : 0) + (isset($old_lastDay['total_revenue']['ipmat-course']) ? $old_lastDay['total_revenue']['ipmat-course'] : 0);

        $data['last_day_revenue']['npat-course'] = (isset($new_lastDay['total_revenue']['npat-course']) ? $new_lastDay['total_revenue']['npat-course'] : 0) + (isset($old_lastDay['total_revenue']['npat-course']) ? $old_lastDay['total_revenue']['npat-course'] : 0);

        $data['last_day_revenue']['cuet-courses'] = (isset($new_lastDay['total_revenue']['cuet-courses']) ? $new_lastDay['total_revenue']['cuet-courses'] : 0) + (isset($old_lastDay['total_revenue']['cuet-courses']) ? $old_lastDay['total_revenue']['cuet-courses'] : 0);
        // Last Day Revenue end

        return $data;
    }

    public function getGDPIData()
    {
        $new_today_count = $old_today_count = $new_today_revenue = $old_today_revenue = $new_lastDay_count = $old_lastDay_count = $new_lastDay_revenue = $old_lastDay_revenue = 0;
        $new_today = $old_today = $new_lastDay = $old_lastDay = $data = [];
        $categories = DB::table('course_categories')
            ->select('id', 'name')
            ->where('name', 'GDPI')
            ->first();

        foreach ($this->getNewTodayCatCourses($categories->id) as $course) {
            $new_today_count += $course->count;
            $new_today_revenue += $course->total_amount;
            $new_today['enrollment'][$course->course_slug] = $course->count;
            $new_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getNewLastDayCatCourses($categories->id) as $course) {
            $new_lastDay_count += $course->count;
            $new_lastDay_revenue += $course->total_amount;
            $new_lastDay['enrollment'][$course->course_slug] = $course->count;
            $new_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldTodayCatCourses($categories->id) as $course) {
            $old_today_count += $course->count;
            $old_today_revenue += $course->total_amount;
            $old_today['enrollment'][$course->course_slug] = $course->count;
            $old_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldLastDayCatCourses($categories->id) as $course) {
            $old_lastDay_count += $course->count;
            $old_lastDay_revenue += $course->total_amount;
            $old_lastDay['enrollment'][$course->course_slug] = $course->count;
            $old_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        $data['total_revenue']['sum'] = $new_today_revenue + $old_today_revenue;
        $lastDayTotalRevenue = ($new_lastDay_revenue + $old_lastDay_revenue) > 0 ? ($new_lastDay_revenue + $old_lastDay_revenue) : 1;
        $data['total_revenue']['per'] = min(($data['total_revenue']['sum'] - $lastDayTotalRevenue) / $lastDayTotalRevenue * 100, 100);

        $data['enrollment']['count'] = $new_today_count + $old_today_count;
        $lastDayTotalEnrollment = ($new_lastDay_count + $old_lastDay_count) > 0 ? ($new_lastDay_count + $old_lastDay_count) : 1;
        $data['enrollment']['per'] = min(($data['enrollment']['count'] - $lastDayTotalEnrollment) / $lastDayTotalEnrollment * 100, 100);

        // Today Enrollment start
        $data['today_enrollment']['gdpi-course'] = (isset($new_today['enrollment']['gdpi-course']) ? $new_today['enrollment']['gdpi-course'] : 0) + (isset($old_today['enrollment']['gdpi-course']) ? $old_today['enrollment']['gdpi-course'] : 0);

        $data['today_enrollment']['iim-wat-pi'] = (isset($new_today['enrollment']['iim-wat-pi']) ? $new_today['enrollment']['iim-wat-pi'] : 0) + (isset($old_today['enrollment']['iim-wat-pi']) ? $old_today['enrollment']['iim-wat-pi'] : 0);

        $data['today_enrollment']['nmims-watpi-course'] = (isset($new_today['enrollment']['nmims-watpi-course']) ? $new_today['enrollment']['nmims-watpi-course'] : 0) + (isset($old_today['enrollment']['nmims-watpi-course']) ? $old_today['enrollment']['nmims-watpi-course'] : 0);

        $data['today_enrollment']['additonal-mock-interview'] = (isset($new_today['enrollment']['additonal-mock-interview']) ? $new_today['enrollment']['additonal-mock-interview'] : 0) + (isset($old_today['enrollment']['additonal-mock-interview']) ? $old_today['enrollment']['additonal-mock-interview'] : 0);
        // Today Enrollment end

        // Today Revenue start
        $data['today_revenue']['gdpi-course'] = (isset($new_today['total_revenue']['gdpi-course']) ? $new_today['total_revenue']['gdpi-course'] : 0) + (isset($old_today['total_revenue']['gdpi-course']) ? $old_today['total_revenue']['gdpi-course'] : 0);

        $data['today_revenue']['iim-wat-pi'] = (isset($new_today['total_revenue']['iim-wat-pi']) ? $new_today['total_revenue']['iim-wat-pi'] : 0) + (isset($old_today['total_revenue']['iim-wat-pi']) ? $old_today['total_revenue']['iim-wat-pi'] : 0);

        $data['today_revenue']['nmims-watpi-course'] = (isset($new_today['total_revenue']['nmims-watpi-course']) ? $new_today['total_revenue']['nmims-watpi-course'] : 0) + (isset($old_today['total_revenue']['nmims-watpi-course']) ? $old_today['total_revenue']['nmims-watpi-course'] : 0);

        $data['today_revenue']['additonal-mock-interview'] = (isset($new_today['total_revenue']['additonal-mock-interview']) ? $new_today['total_revenue']['additonal-mock-interview'] : 0) + (isset($old_today['total_revenue']['additonal-mock-interview']) ? $old_today['total_revenue']['additonal-mock-interview'] : 0);
        // Today Revenue end

        // Last Day Enrollment start
        $data['last_day_enrollment']['gdpi-course'] = (isset($new_lastDay['enrollment']['gdpi-course']) ? $new_lastDay['enrollment']['gdpi-course'] : 0) + (isset($old_lastDay['enrollment']['gdpi-course']) ? $old_lastDay['enrollment']['gdpi-course'] : 0);

        $data['last_day_enrollment']['iim-wat-pi'] = (isset($new_lastDay['enrollment']['iim-wat-pi']) ? $new_lastDay['enrollment']['iim-wat-pi'] : 0) + (isset($old_lastDay['enrollment']['iim-wat-pi']) ? $old_lastDay['enrollment']['iim-wat-pi'] : 0);

        $data['last_day_enrollment']['nmims-watpi-course'] = (isset($new_lastDay['enrollment']['nmims-watpi-course']) ? $new_lastDay['enrollment']['nmims-watpi-course'] : 0) + (isset($old_lastDay['enrollment']['nmims-watpi-course']) ? $old_lastDay['enrollment']['nmims-watpi-course'] : 0);

        $data['last_day_enrollment']['additonal-mock-interview'] = (isset($new_lastDay['enrollment']['additonal-mock-interview']) ? $new_lastDay['enrollment']['additonal-mock-interview'] : 0) + (isset($old_lastDay['enrollment']['additonal-mock-interview']) ? $old_lastDay['enrollment']['additonal-mock-interview'] : 0);
        // Last Day Enrollment end

        // Last Day Revenue start
        $data['last_day_revenue']['gdpi-course'] = (isset($new_lastDay['total_revenue']['gdpi-course']) ? $new_lastDay['total_revenue']['gdpi-course'] : 0) + (isset($old_lastDay['total_revenue']['gdpi-course']) ? $old_lastDay['total_revenue']['gdpi-course'] : 0);

        $data['last_day_revenue']['iim-wat-pi'] = (isset($new_lastDay['total_revenue']['iim-wat-pi']) ? $new_lastDay['total_revenue']['iim-wat-pi'] : 0) + (isset($old_lastDay['total_revenue']['iim-wat-pi']) ? $old_lastDay['total_revenue']['iim-wat-pi'] : 0);

        $data['last_day_revenue']['nmims-watpi-course'] = (isset($new_lastDay['total_revenue']['nmims-watpi-course']) ? $new_lastDay['total_revenue']['nmims-watpi-course'] : 0) + (isset($old_lastDay['total_revenue']['nmims-watpi-course']) ? $old_lastDay['total_revenue']['nmims-watpi-course'] : 0);

        $data['last_day_revenue']['additonal-mock-interview'] = (isset($new_lastDay['total_revenue']['additonal-mock-interview']) ? $new_lastDay['total_revenue']['additonal-mock-interview'] : 0) + (isset($old_lastDay['total_revenue']['additonal-mock-interview']) ? $old_lastDay['total_revenue']['additonal-mock-interview'] : 0);
        // Last Day Revenue end

        return $data;
    }

    public function getMocksData()
    {
        $new_today_count = $old_today_count = $new_today_revenue = $old_today_revenue = $new_lastDay_count = $old_lastDay_count = $new_lastDay_revenue = $old_lastDay_revenue = 0;
        $new_today = $old_today = $new_lastDay = $old_lastDay = $data = [];
        $categories = DB::table('course_categories')
            ->select('id', 'name')
            ->where('name', 'Mocks')
            ->first();

        foreach ($this->getNewTodayCatCourses($categories->id) as $course) {
            $new_today_count += $course->count;
            $new_today_revenue += $course->total_amount;
            $new_today['enrollment'][$course->course_slug] = $course->count;
            $new_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getNewLastDayCatCourses($categories->id) as $course) {
            $new_lastDay_count += $course->count;
            $new_lastDay_revenue += $course->total_amount;
            $new_lastDay['enrollment'][$course->course_slug] = $course->count;
            $new_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldTodayCatCourses($categories->id) as $course) {
            $old_today_count += $course->count;
            $old_today_revenue += $course->total_amount;
            $old_today['enrollment'][$course->course_slug] = $course->count;
            $old_today['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        foreach ($this->getOldLastDayCatCourses($categories->id) as $course) {
            $old_lastDay_count += $course->count;
            $old_lastDay_revenue += $course->total_amount;
            $old_lastDay['enrollment'][$course->course_slug] = $course->count;
            $old_lastDay['total_revenue'][$course->course_slug] = $course->total_amount;
        }

        $data['total_revenue']['sum'] = $new_today_revenue + $old_today_revenue;
        $lastDayTotalRevenue = ($new_lastDay_revenue + $old_lastDay_revenue) > 0 ? ($new_lastDay_revenue + $old_lastDay_revenue) : 1;
        $data['total_revenue']['per'] = min(($data['total_revenue']['sum'] - $lastDayTotalRevenue) / $lastDayTotalRevenue * 100, 100);

        $data['enrollment']['count'] = $new_today_count + $old_today_count;
        $lastDayTotalEnrollment = ($new_lastDay_count + $old_lastDay_count) > 0 ? ($new_lastDay_count + $old_lastDay_count) : 1;
        $data['enrollment']['per'] = min(($data['enrollment']['count'] - $lastDayTotalEnrollment) / $lastDayTotalEnrollment * 100, 100);

        // Today Enrollment start
        $data['today_enrollment']['all-mocks'] = (isset($new_today['enrollment']['all-mocks']) ? $new_today['enrollment']['all-mocks'] : 0) + (isset($old_today['enrollment']['all-mocks']) ? $old_today['enrollment']['all-mocks'] : 0);

        $data['today_enrollment']['cat-mock'] = (isset($new_today['enrollment']['cat-mock']) ? $new_today['enrollment']['cat-mock'] : 0) + (isset($old_today['enrollment']['cat-mock']) ? $old_today['enrollment']['cat-mock'] : 0);

        $data['today_enrollment']['cat-turbo-mock'] = (isset($new_today['enrollment']['cat-turbo-mock']) ? $new_today['enrollment']['cat-turbo-mock'] : 0) + (isset($old_today['enrollment']['cat-turbo-mock']) ? $old_today['enrollment']['cat-turbo-mock'] : 0);

        $data['today_enrollment']['cat-advance-mock'] = (isset($new_today['enrollment']['cat-advance-mock']) ? $new_today['enrollment']['cat-advance-mock'] : 0) + (isset($old_today['enrollment']['cat-advance-mock']) ? $old_today['enrollment']['cat-advance-mock'] : 0);

        $data['today_enrollment']['books-and-mocks'] = (isset($new_today['enrollment']['books-and-mocks']) ? $new_today['enrollment']['books-and-mocks'] : 0) + (isset($old_today['enrollment']['books-and-mocks']) ? $old_today['enrollment']['books-and-mocks'] : 0);

        $data['today_enrollment']['nmat-mocks'] = (isset($new_today['enrollment']['nmat-mocks']) ? $new_today['enrollment']['nmat-mocks'] : 0) + (isset($old_today['enrollment']['nmat-mocks']) ? $old_today['enrollment']['nmat-mocks'] : 0);

        $data['today_enrollment']['snap-mocks'] = (isset($new_today['enrollment']['snap-mocks']) ? $new_today['enrollment']['snap-mocks'] : 0) + (isset($old_today['enrollment']['snap-mocks']) ? $old_today['enrollment']['snap-mocks'] : 0);

        $data['today_enrollment']['cet-mocks'] = (isset($new_today['enrollment']['cet-mocks']) ? $new_today['enrollment']['cet-mocks'] : 0) + (isset($old_today['enrollment']['cet-mocks']) ? $old_today['enrollment']['cet-mocks'] : 0);

        $data['today_enrollment']['srcc-gbo-mock'] = (isset($new_today['enrollment']['srcc-gbo-mock']) ? $new_today['enrollment']['srcc-gbo-mock'] : 0) + (isset($old_today['enrollment']['srcc-gbo-mock']) ? $old_today['enrollment']['srcc-gbo-mock'] : 0);

        $data['today_enrollment']['iift-mocks'] = (isset($new_today['enrollment']['iift-mocks']) ? $new_today['enrollment']['iift-mocks'] : 0) + (isset($old_today['enrollment']['iift-mocks']) ? $old_today['enrollment']['iift-mocks'] : 0);

        $data['today_enrollment']['tissnet-mocks'] = (isset($new_today['enrollment']['tissnet-mocks']) ? $new_today['enrollment']['tissnet-mocks'] : 0) + (isset($old_today['enrollment']['tissnet-mocks']) ? $old_today['enrollment']['tissnet-mocks'] : 0);

        $data['today_enrollment']['mat-mock'] = (isset($new_today['enrollment']['mat-mock']) ? $new_today['enrollment']['mat-mock'] : 0) + (isset($old_today['enrollment']['mat-mock']) ? $old_today['enrollment']['mat-mock'] : 0);

        $data['today_enrollment']['atma-mock'] = (isset($new_today['enrollment']['atma-mock']) ? $new_today['enrollment']['atma-mock'] : 0) + (isset($old_today['enrollment']['atma-mock']) ? $old_today['enrollment']['atma-mock'] : 0);
        // Today Enrollment end

        // Today Revenue start
        $data['today_revenue']['all-mocks'] = (isset($new_today['total_revenue']['all-mocks']) ? $new_today['total_revenue']['all-mocks'] : 0) + (isset($old_today['total_revenue']['all-mocks']) ? $old_today['total_revenue']['all-mocks'] : 0);

        $data['today_revenue']['cat-mock'] = (isset($new_today['total_revenue']['cat-mock']) ? $new_today['total_revenue']['cat-mock'] : 0) + (isset($old_today['total_revenue']['cat-mock']) ? $old_today['total_revenue']['cat-mock'] : 0);

        $data['today_revenue']['cat-turbo-mock'] = (isset($new_today['total_revenue']['cat-turbo-mock']) ? $new_today['total_revenue']['cat-turbo-mock'] : 0) + (isset($old_today['total_revenue']['cat-turbo-mock']) ? $old_today['total_revenue']['cat-turbo-mock'] : 0);

        $data['today_revenue']['cat-advance-mock'] = (isset($new_today['total_revenue']['cat-advance-mock']) ? $new_today['total_revenue']['cat-advance-mock'] : 0) + (isset($old_today['total_revenue']['cat-advance-mock']) ? $old_today['total_revenue']['cat-advance-mock'] : 0);

        $data['today_revenue']['books-and-mocks'] = (isset($new_today['total_revenue']['books-and-mocks']) ? $new_today['total_revenue']['books-and-mocks'] : 0) + (isset($old_today['total_revenue']['books-and-mocks']) ? $old_today['total_revenue']['books-and-mocks'] : 0);

        $data['today_revenue']['nmat-mocks'] = (isset($new_today['total_revenue']['nmat-mocks']) ? $new_today['total_revenue']['nmat-mocks'] : 0) + (isset($old_today['total_revenue']['nmat-mocks']) ? $old_today['total_revenue']['nmat-mocks'] : 0);

        $data['today_revenue']['snap-mocks'] = (isset($new_today['total_revenue']['snap-mocks']) ? $new_today['total_revenue']['snap-mocks'] : 0) + (isset($old_today['total_revenue']['snap-mocks']) ? $old_today['total_revenue']['snap-mocks'] : 0);

        $data['today_revenue']['cet-mocks'] = (isset($new_today['total_revenue']['cet-mocks']) ? $new_today['total_revenue']['cet-mocks'] : 0) + (isset($old_today['total_revenue']['cet-mocks']) ? $old_today['total_revenue']['cet-mocks'] : 0);

        $data['today_revenue']['srcc-gbo-mock'] = (isset($new_today['total_revenue']['srcc-gbo-mock']) ? $new_today['total_revenue']['srcc-gbo-mock'] : 0) + (isset($old_today['total_revenue']['srcc-gbo-mock']) ? $old_today['total_revenue']['srcc-gbo-mock'] : 0);

        $data['today_revenue']['iift-mocks'] = (isset($new_today['total_revenue']['iift-mocks']) ? $new_today['total_revenue']['iift-mocks'] : 0) + (isset($old_today['total_revenue']['iift-mocks']) ? $old_today['total_revenue']['iift-mocks'] : 0);

        $data['today_revenue']['tissnet-mocks'] = (isset($new_today['total_revenue']['tissnet-mocks']) ? $new_today['total_revenue']['tissnet-mocks'] : 0) + (isset($old_today['total_revenue']['tissnet-mocks']) ? $old_today['total_revenue']['tissnet-mocks'] : 0);

        $data['today_revenue']['mat-mock'] = (isset($new_today['total_revenue']['mat-mock']) ? $new_today['total_revenue']['mat-mock'] : 0) + (isset($old_today['total_revenue']['mat-mock']) ? $old_today['total_revenue']['mat-mock'] : 0);

        $data['today_revenue']['atma-mock'] = (isset($new_today['total_revenue']['atma-mock']) ? $new_today['total_revenue']['atma-mock'] : 0) + (isset($old_today['total_revenue']['atma-mock']) ? $old_today['total_revenue']['atma-mock'] : 0);
        // Today Revenue end

        // Last Day Enrollment start
        $data['last_day_enrollment']['all-mocks'] = (isset($new_lastDay['enrollment']['all-mocks']) ? $new_lastDay['enrollment']['all-mocks'] : 0) + (isset($old_lastDay['enrollment']['all-mocks']) ? $old_lastDay['enrollment']['all-mocks'] : 0);

        $data['last_day_enrollment']['cat-mock'] = (isset($new_lastDay['enrollment']['cat-mock']) ? $new_lastDay['enrollment']['cat-mock'] : 0) + (isset($old_lastDay['enrollment']['cat-mock']) ? $old_lastDay['enrollment']['cat-mock'] : 0);

        $data['last_day_enrollment']['cat-turbo-mock'] = (isset($new_lastDay['enrollment']['cat-turbo-mock']) ? $new_lastDay['enrollment']['cat-turbo-mock'] : 0) + (isset($old_lastDay['enrollment']['cat-turbo-mock']) ? $old_lastDay['enrollment']['cat-turbo-mock'] : 0);

        $data['last_day_enrollment']['cat-advance-mock'] = (isset($new_lastDay['enrollment']['cat-advance-mock']) ? $new_lastDay['enrollment']['cat-advance-mock'] : 0) + (isset($old_lastDay['enrollment']['cat-advance-mock']) ? $old_lastDay['enrollment']['cat-advance-mock'] : 0);

        $data['last_day_enrollment']['books-and-mocks'] = (isset($new_lastDay['enrollment']['books-and-mocks']) ? $new_lastDay['enrollment']['books-and-mocks'] : 0) + (isset($old_lastDay['enrollment']['books-and-mocks']) ? $old_lastDay['enrollment']['books-and-mocks'] : 0);

        $data['last_day_enrollment']['nmat-mocks'] = (isset($new_lastDay['enrollment']['nmat-mocks']) ? $new_lastDay['enrollment']['nmat-mocks'] : 0) + (isset($old_lastDay['enrollment']['nmat-mocks']) ? $old_lastDay['enrollment']['nmat-mocks'] : 0);

        $data['last_day_enrollment']['snap-mocks'] = (isset($new_lastDay['enrollment']['snap-mocks']) ? $new_lastDay['enrollment']['snap-mocks'] : 0) + (isset($old_lastDay['enrollment']['snap-mocks']) ? $old_lastDay['enrollment']['snap-mocks'] : 0);

        $data['last_day_enrollment']['cet-mocks'] = (isset($new_lastDay['enrollment']['cet-mocks']) ? $new_lastDay['enrollment']['cet-mocks'] : 0) + (isset($old_lastDay['enrollment']['cet-mocks']) ? $old_lastDay['enrollment']['cet-mocks'] : 0);

        $data['last_day_enrollment']['srcc-gbo-mock'] = (isset($new_lastDay['enrollment']['srcc-gbo-mock']) ? $new_lastDay['enrollment']['srcc-gbo-mock'] : 0) + (isset($old_lastDay['enrollment']['srcc-gbo-mock']) ? $old_lastDay['enrollment']['srcc-gbo-mock'] : 0);

        $data['last_day_enrollment']['iift-mocks'] = (isset($new_lastDay['enrollment']['iift-mocks']) ? $new_lastDay['enrollment']['iift-mocks'] : 0) + (isset($old_lastDay['enrollment']['iift-mocks']) ? $old_lastDay['enrollment']['iift-mocks'] : 0);

        $data['last_day_enrollment']['tissnet-mocks'] = (isset($new_lastDay['enrollment']['tissnet-mocks']) ? $new_lastDay['enrollment']['tissnet-mocks'] : 0) + (isset($old_lastDay['enrollment']['tissnet-mocks']) ? $old_lastDay['enrollment']['tissnet-mocks'] : 0);

        $data['last_day_enrollment']['mat-mock'] = (isset($new_lastDay['enrollment']['mat-mock']) ? $new_lastDay['enrollment']['mat-mock'] : 0) + (isset($old_lastDay['enrollment']['mat-mock']) ? $old_lastDay['enrollment']['mat-mock'] : 0);

        $data['last_day_enrollment']['atma-mock'] = (isset($new_lastDay['enrollment']['atma-mock']) ? $new_lastDay['enrollment']['atma-mock'] : 0) + (isset($old_lastDay['enrollment']['atma-mock']) ? $old_lastDay['enrollment']['atma-mock'] : 0);
        // Last Day Enrollment end

        // Last Day Revenue start
        $data['last_day_revenue']['all-mocks'] = (isset($new_lastDay['total_revenue']['all-mocks']) ? $new_lastDay['total_revenue']['all-mocks'] : 0) + (isset($old_lastDay['total_revenue']['all-mocks']) ? $old_lastDay['total_revenue']['all-mocks'] : 0);

        $data['last_day_revenue']['cat-mock'] = (isset($new_lastDay['total_revenue']['cat-mock']) ? $new_lastDay['total_revenue']['cat-mock'] : 0) + (isset($old_lastDay['total_revenue']['cat-mock']) ? $old_lastDay['total_revenue']['cat-mock'] : 0);

        $data['last_day_revenue']['cat-turbo-mock'] = (isset($new_lastDay['total_revenue']['cat-turbo-mock']) ? $new_lastDay['total_revenue']['cat-turbo-mock'] : 0) + (isset($old_lastDay['total_revenue']['cat-turbo-mock']) ? $old_lastDay['total_revenue']['cat-turbo-mock'] : 0);

        $data['last_day_revenue']['cat-advance-mock'] = (isset($new_lastDay['total_revenue']['cat-advance-mock']) ? $new_lastDay['total_revenue']['cat-advance-mock'] : 0) + (isset($old_lastDay['total_revenue']['cat-advance-mock']) ? $old_lastDay['total_revenue']['cat-advance-mock'] : 0);

        $data['last_day_revenue']['books-and-mocks'] = (isset($new_lastDay['total_revenue']['books-and-mocks']) ? $new_lastDay['total_revenue']['books-and-mocks'] : 0) + (isset($old_lastDay['total_revenue']['books-and-mocks']) ? $old_lastDay['total_revenue']['books-and-mocks'] : 0);

        $data['last_day_revenue']['nmat-mocks'] = (isset($new_lastDay['total_revenue']['nmat-mocks']) ? $new_lastDay['total_revenue']['nmat-mocks'] : 0) + (isset($old_lastDay['total_revenue']['nmat-mocks']) ? $old_lastDay['total_revenue']['nmat-mocks'] : 0);

        $data['last_day_revenue']['snap-mocks'] = (isset($new_lastDay['total_revenue']['snap-mocks']) ? $new_lastDay['total_revenue']['snap-mocks'] : 0) + (isset($old_lastDay['total_revenue']['snap-mocks']) ? $old_lastDay['total_revenue']['snap-mocks'] : 0);

        $data['last_day_revenue']['cet-mocks'] = (isset($new_lastDay['total_revenue']['cet-mocks']) ? $new_lastDay['total_revenue']['cet-mocks'] : 0) + (isset($old_lastDay['total_revenue']['cet-mocks']) ? $old_lastDay['total_revenue']['cet-mocks'] : 0);

        $data['last_day_revenue']['srcc-gbo-mock'] = (isset($new_lastDay['total_revenue']['srcc-gbo-mock']) ? $new_lastDay['total_revenue']['srcc-gbo-mock'] : 0) + (isset($old_lastDay['total_revenue']['srcc-gbo-mock']) ? $old_lastDay['total_revenue']['srcc-gbo-mock'] : 0);

        $data['last_day_revenue']['iift-mocks'] = (isset($new_lastDay['total_revenue']['iift-mocks']) ? $new_lastDay['total_revenue']['iift-mocks'] : 0) + (isset($old_lastDay['total_revenue']['iift-mocks']) ? $old_lastDay['total_revenue']['iift-mocks'] : 0);

        $data['last_day_revenue']['tissnet-mocks'] = (isset($new_lastDay['total_revenue']['tissnet-mocks']) ? $new_lastDay['total_revenue']['tissnet-mocks'] : 0) + (isset($old_lastDay['total_revenue']['tissnet-mocks']) ? $old_lastDay['total_revenue']['tissnet-mocks'] : 0);

        $data['last_day_revenue']['mat-mock'] = (isset($new_lastDay['total_revenue']['mat-mock']) ? $new_lastDay['total_revenue']['mat-mock'] : 0) + (isset($old_lastDay['total_revenue']['mat-mock']) ? $old_lastDay['total_revenue']['mat-mock'] : 0);

        $data['last_day_revenue']['atma-mock'] = (isset($new_lastDay['total_revenue']['atma-mock']) ? $new_lastDay['total_revenue']['atma-mock'] : 0) + (isset($old_lastDay['total_revenue']['atma-mock']) ? $old_lastDay['total_revenue']['atma-mock'] : 0);
        // Last Day Revenue end

        return $data;
    }

    public function getNewTodayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.name as course_name,courses.slug as course_slug,COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.course_id', 'courses.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }

    public function getNewLastDayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.name as course_name,courses.slug as course_slug,COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.course_id', 'courses.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }

    public function getOldTodayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.name as course_name,courses.slug as course_slug,COUNT(old_orders.id) as count,SUM(old_orders.total_revenue) as total_amount')
            ->join('old_orders', 'old_orders.name', 'courses.name')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('old_orders.order_date', [$this->startDate, $this->endDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }

    public function getOldLastDayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.name as course_name,courses.slug as course_slug,COUNT(old_orders.id) as count,SUM(old_orders.total_revenue) as total_amount')
            ->join('old_orders', 'old_orders.name', 'courses.name')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('old_orders.order_date', [$this->previousStartDate, $this->previousEndDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }
}
