<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CEOController extends Controller {

    public $startDate, $endDate, $lastStartDate, $lastEndDate, $previousStartDate, $previousEndDate;

    public function index(Request $request) {
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
            $selectedStartDate = Carbon::parse($this->startDate)->format('Y-m-d');
            $selectedEndDate = Carbon::parse($this->endDate)->format('Y-m-d');

            if ($course == 'sales') {
                $sales = $this->getSalesData();
                $calls = $this->getCallsData($date);

                // return json_encode($sales);
                return view('Admin.CeoRevenue.sales', ['date' => $date, 'sales' => $sales, 'calls' => $calls, 'startDate' => $this->startDate, 'endDate' => $this->endDate, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } elseif ($course == 'cat') {
                // $cat = $this->getCATData();
                $commonGraph = $this->commonData('cat');
                // return json_encode($commonGraph);
                return view('Admin.CeoRevenue.commonGraph', ['date' => $date, 'commonGraph' => $commonGraph, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } elseif ($course == 'non_cat') {
                // $nonCat = $this->getNonCATData();
                $commonGraph = $this->commonData('non-cat');
                // return json_encode($nonCat);
                return view('Admin.CeoRevenue.commonGraph', ['date' => $date, 'commonGraph' => $commonGraph, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } elseif ($course == 'study_abroad') {
                // $studyAbroad = $this->getStudyAbroadData();
                $commonGraph = $this->commonData('study-abroad');
                // return json_encode($commonGraph);
                return view('Admin.CeoRevenue.commonGraph', ['date' => $date, 'commonGraph' => $commonGraph, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } elseif ($course == 'undergrad') {
                // $undergrad = $this->getUnderGradData();
                $commonGraph = $this->commonData('undergrad');
                // return json_encode($undergrad);
                return view('Admin.CeoRevenue.commonGraph', ['date' => $date, 'commonGraph' => $commonGraph, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } elseif ($course == 'gdpi') {
                // $gdpi = $this->getGDPIData();
                $commonGraph = $this->commonData('gdpi');
                // return json_encode($gdpi);
                return view('Admin.CeoRevenue.commonGraph', ['date' => $date, 'commonGraph' => $commonGraph, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } elseif ($course == 'mocks') {
                // $mocks = $this->getMocksData();
                $commonGraph = $this->commonData('mocks');
                // return json_encode($mocks);
                return view('Admin.CeoRevenue.commonGraph', ['date' => $date, 'commonGraph' => $commonGraph, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            } else {
                $revenue = $this->getRevenueData();
                // return json_encode($revenue);
                return view('Admin.CeoRevenue.revenue', ['date' => $date, 'revenue' => $revenue, 'selectedStartDate' => $selectedStartDate, 'selectedEndDate' => $selectedEndDate]);
            }

            return '<h1>Hello Dashboard</h1>';
        }
        return view('Admin.CeoRevenue.index');
    }

    public function getStartEndDate($date = 'today') {
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

    public function getRevenueData() {
        $perviousOrderCount = 0;
        $data = $courses = $countData = $userIds = $complete_order = $orderIds = [];

        // This Year :: total No of enrollment start
        $new_order_today = DB::table('orders')
                ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('courses', 'courses.id', '=', 'order_items.course_id')
                ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
                ->where('orders.payment_status', 'completed')
                ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                ->first();

        // $old_order_today = DB::table('old_orders')->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')->whereBetween('order_date', [$this->startDate, $this->endDate])->first();

        $newWPOrder = DB::table('wp_orders')->selectRaw('SUM(order_count) as count,SUM(total_sales_amt) as total_amount')->whereBetween('date', [$this->startDate, $this->endDate])->first();

        // $data['this_year_total_enrollments'] = $new_order_today->count + $old_order_today->count + $newWPOrder->count;
        // $data['this_year_total_revenue'] = ($new_order_today->total_amount + $old_order_today->total_amount + $newWPOrder->total_amount);

        $data['this_year_total_enrollments'] = $new_order_today->count + $newWPOrder->count;
        $data['this_year_total_revenue'] = $new_order_today->total_amount + $newWPOrder->total_amount;

        // This Year :: total No of enrollment end
        // Last Year :: total No of enrollment start
        $new_last_year_total = DB::table('orders')
                ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('courses', 'courses.id', '=', 'order_items.course_id')
                ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
                ->where('orders.payment_status', 'completed')
                ->whereBetween('orders.created_at', [$this->lastStartDate, $this->lastEndDate])
                ->first();
        // $new_last_year_total = DB::table('orders')->selectRaw('COUNT(id) as count,SUM(total) as total_amount')->where('payment_status', 'completed')->whereBetween('created_at', [$this->lastStartDate, $this->lastEndDate])->first();
        //$old_last_year_total = DB::table('old_orders')->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')->whereBetween('order_date', [$this->lastStartDate, $this->lastEndDate])->first();

        $oldWPOrder = DB::table('wp_orders')->selectRaw('SUM(order_count) as count,SUM(total_sales_amt) as total_amount')->whereBetween('date', [$this->lastStartDate, $this->lastEndDate])->first();

        // $data['last_year_total_enrollments'] = $new_last_year_total->count + $old_last_year_total->count + $oldWPOrder->count;
        // $data['last_year_total_revenue'] = (int) ($new_last_year_total->total_amount + $old_last_year_total->total_amount + $oldWPOrder->total_amount);

        $data['last_year_total_enrollments'] = $new_last_year_total->count + $oldWPOrder->count;
        $data['last_year_total_revenue'] = (int) ($new_last_year_total->total_amount + $oldWPOrder->total_amount);
        // $data['last_year_total_revenue'] = $lastYearTotalRevenue != 0 ? $lastYearTotalRevenue : 1;
        // Last Year :: total No of enrollment end
        // Enrollment Per start
        $data['this_year_total_enrollments_per'] = perFindValue($data['this_year_total_enrollments'], $data['last_year_total_enrollments']);
        $data['last_year_total_enrollments_per'] = perFindValue($data['last_year_total_enrollments'], $data['this_year_total_enrollments']);
        $data['this_year_total_revenue_per'] = perFindValue($data['this_year_total_revenue'], $data['last_year_total_revenue']);
        $data['last_year_total_revenue_per'] = perFindValue($data['last_year_total_revenue'], $data['this_year_total_revenue']);
        $data['total_revenue_per'] = perFindAvg($data['this_year_total_revenue'], $data['last_year_total_revenue']);
        $data['total_enrollments_per'] = perFindAvg($data['this_year_total_enrollments'], $data['last_year_total_enrollments']);
        // Enrollment Per end
        // return $data;
        // This Year :: enrollments through Installments & EMI start
        $new_this_year_emi_enrollments = DB::table('orders')
                        ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('courses', 'courses.id', '=', 'order_items.course_id')
                        ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                        ->where(function ($q) {
                            $q->where('courses.name', 'like', '%installment%')
                            ->orWhere('courses.name', 'like', '%emi%');
                        })->where('orders.payment_status', 'completed')->first();

        // $old_this_year_emi_enrollments = DB::table('old_orders')
        //     ->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')
        //     ->where(function ($q) {
        //         $q->where('name', 'like', '%installment%')->orWhere('name', 'like', '%emi%');
        //     })->whereBetween('order_date', [$this->startDate, $this->endDate])->first();
        // $data['this_year_emi_enrollments'] = $new_this_year_emi_enrollments->count + $old_this_year_emi_enrollments->count;
        // $data['this_year_emi_revenue'] = (int) ($new_this_year_emi_enrollments->total_amount + $old_this_year_emi_enrollments->total_amount);

        $data['this_year_emi_enrollments'] = $new_this_year_emi_enrollments->count;
        $data['this_year_emi_revenue'] = $new_this_year_emi_enrollments->total_amount;
        // This Year :: enrollments through Installments & EMI end
        // Last Year :: enrollments through Installments & EMI start
        $new_last_year_emi_enrollments = DB::table('orders')
                        ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('courses', 'courses.id', '=', 'order_items.course_id')
                        ->whereBetween('orders.created_at', [$this->lastStartDate, $this->lastEndDate])
                        ->where(function ($q) {
                            $q->where('courses.name', 'like', '%installment%')
                            ->orWhere('courses.name', 'like', '%emi%');
                        })->where('orders.payment_status', 'completed')->first();

        // $old_last_year_emi_enrollments = DB::table('old_orders')
        //     ->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')
        //     ->where(function ($q) {
        //         $q->where('name', 'like', '%installment%')->orWhere('name', 'like', '%emi%');
        //     })->whereBetween('order_date', [$this->lastStartDate, $this->lastEndDate])->first();
        // $data['last_year_emi_enrollments'] = $new_last_year_emi_enrollments->count + $old_last_year_emi_enrollments->count;
        // $data['last_year_emi_revenue'] = (int) ($new_last_year_emi_enrollments->total_amount + $old_last_year_emi_enrollments->total_amount);
        $data['last_year_emi_enrollments'] = $new_last_year_emi_enrollments->count;
        $data['last_year_emi_revenue'] = $new_last_year_emi_enrollments->total_amount;
        // Last Year :: enrollments through Installments & EMI end
        // Enrollment through Installments & EMI start
        $data['this_year_emi_enrollments_per'] = perFindValue($data['this_year_emi_enrollments'], $data['last_year_emi_enrollments']);
        $data['last_year_emi_enrollments_per'] = perFindValue($data['last_year_emi_enrollments'], $data['this_year_emi_enrollments']);
        $data['this_year_emi_revenue_per'] = perFindValue($data['this_year_emi_revenue'], $data['last_year_emi_revenue']);
        $data['last_year_emi_revenue_per'] = perFindValue($data['last_year_emi_revenue'], $data['this_year_emi_revenue']);
        $data['total_emi_revenue_per'] = perFindAvg($data['this_year_emi_revenue'], $data['last_year_emi_revenue']);
        $data['total_emi_enrollments_per'] = perFindAvg($data['this_year_emi_enrollments'], $data['last_year_emi_enrollments']);
        // Enrollment through Installments & EMI end
        // Total No of enrollment Chart And Table start
        $course_categories = DB::table('course_categories')->select('name', 'slug')->get();
        foreach ($course_categories as $course) {
            $countData['enrollment'][$course->slug] = 0;
            $countData['today_day_total_revenue'][$course->slug] = 0;
            $countData['previous_day_total_revenue'][$course->slug] = 0;
            $courses[] = $course->name;
        }
        $countData['enrollment']['old_order'] = 0;
        $countData['today_day_total_revenue']['old_order'] = 0;
        $countData['previous_day_total_revenue']['old_order'] = 0;
        array_push($courses, 'Old Order');
        $data['course_name'] = $courses;

        $new_today_orders = DB::table('orders')
                ->selectRaw('course_categories.slug as course_category_slug, count(orders.id) as order_count,sum(orders.total) as total_revenue')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('courses', 'courses.id', '=', 'order_items.course_id')
                ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
                // ->where('courses.show_on_menu', '=', 'yes')
                // ->where('courses.status', '=', 'published')
                ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                ->where('orders.payment_status', 'completed')
                ->groupBy('course_categories.slug')
                // ->orderByDesc('order_count')
                ->get();

        // $old_today_orders = DB::table('old_orders')
        //     ->selectRaw('course_categories.slug as course_category_slug, count(old_orders.id) as order_count,sum(old_orders.total_revenue) as total_revenue')
        //     ->join('courses', 'courses.name', '=', 'old_orders.name')
        //     ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
        //     ->whereBetween('old_orders.order_date', [$this->startDate, $this->endDate])
        //     ->groupBy('course_categories.slug')
        //     ->orderByDesc('order_count')
        //     ->get();

        $old_today_orders = DB::table('wp_orders')->selectRaw('SUM(order_count) as order_count,SUM(total_sales_amt) as total_revenue')->whereBetween('date', [$this->startDate, $this->endDate])->first();

        $new_previous_orders = DB::table('orders')
                ->selectRaw('course_categories.slug as course_category_slug, count(orders.id) as order_count,sum(orders.total) as total_revenue')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('courses', 'courses.id', '=', 'order_items.course_id')
                ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
                // ->where('courses.show_on_menu', '=', 'yes')
                // ->where('courses.status', '=', 'published')
                ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
                ->where('orders.payment_status', 'completed')
                ->groupBy('course_categories.slug')
                // ->pluck('total_revenue', 'course_category_slug')
                // ->toArray();
                ->get();

        // $old_previous_orders = DB::table('old_orders')
        //     ->selectRaw('course_categories.slug as course_category_slug,count(old_orders.id) as order_count,sum(old_orders.total_revenue) as total_revenue')
        //     ->join('courses', 'courses.name', '=', 'old_orders.name')
        //     ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
        //     ->whereBetween('old_orders.order_date', [$this->previousStartDate, $this->previousStartDate])
        //     ->groupBy('course_categories.slug')
        // // ->pluck('total_revenue', 'course_category_slug')->toArray();
        //     ->get();
        $old_previous_orders = DB::table('wp_orders')->selectRaw('SUM(order_count) as order_count,SUM(total_sales_amt) as total_revenue')->whereBetween('date', [$this->previousStartDate, $this->previousStartDate])->first();

        foreach ($new_today_orders as $order) {
            $countData['enrollment'][$order->course_category_slug] += $order->order_count;
            $countData['today_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        }

        // foreach ($old_today_orders as $order) {
        // $countData['enrollment'][$order->course_category_slug] += $order->order_count;
        // $countData['today_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        $countData['enrollment']['old_order'] += isset($old_today_orders->order_count) ? $old_today_orders->order_count : 0;
        $countData['today_day_total_revenue']['old_order'] += isset($old_today_orders->total_revenue) ? $old_today_orders->total_revenue : 0;
        // }

        foreach ($new_previous_orders as $order) {
            $perviousOrderCount += $order->order_count;
            $countData['previous_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        }

        // foreach ($old_previous_orders as $order) {
        // $perviousOrderCount += $order->order_count;
        // $countData['previous_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        // $countData['enrollment']['old_order'] += isset($old_previous_orders->order_count) ? $old_previous_orders->order_count : 0;
        $countData['previous_day_total_revenue']['old_order'] += isset($old_previous_orders->total_revenue) ? $old_previous_orders->total_revenue : 0;
        // }
        //revenue chart start
        $data['today_revenue'] = array_values($countData['today_day_total_revenue']);
        $data['previous_day_revenue'] = array_values($countData['previous_day_total_revenue']);
        $todayTotalRevenue = array_sum($data['today_revenue']);
        $data['total_today_revenue'] = numberFormat($todayTotalRevenue);
        $data['total_per_revenue'] = perFindAvg($todayTotalRevenue, array_sum($data['previous_day_revenue']));
        //revenue chart end
        //pie chart start
        $data['total_no_enrollment_sum'] = array_sum($countData['enrollment']);
        $data['total_no_enrollment_per'] = perFindAvg($data['total_no_enrollment_sum'], $perviousOrderCount);
        $data['total_no_enrollment'] = $countData['enrollment'];
        $data['enrollment_max'] = max($countData['enrollment']);
        // return   $data['total_enrollment'];
        // $data['enrollment_per_avg'] = perFindAvg($totalOrderCount, $perviousOrderCount);
        // foreach ($countData['enrollment'] as $key => $order) {
        //     $countData['enrollment_per'][$key] = $countData['enrollment'][$key] != 0 ? round(($countData['enrollment'][$key] / $totalOrderCount * 100), 2) : 0;
        // }
        // $data['enrollment_max'] = max(array_values($countData['enrollment_per']));
        // $data['enrollment_per'] = $countData['enrollment_per'];
        // $data['leads'] = $countData['enrollment'];
        //pie chart end
        // Total No of enrollment Chart And Table end
        // Failed Order List Start
        $failed_order_user = DB::table('orders')
                ->selectRaw('orders.id as order_id,orders.user_id as user_id, order_items.course_id as course_id,order_items.id as order_item_id')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', ["$this->startDate", "$this->endDate"])
                ->whereIn('orders.payment_status', ['timeout', 'failed', 'pending'])
                // ->groupBy('orders.user_id', 'order_items.course_id')
                ->get();
        // ->pluck('orders.user_id')->toArray();

        foreach ($failed_order_user as $order) {
            $userIds[] = $order->user_id;
        }
        $complete_order = DB::table('orders')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->where('orders.payment_status', 'completed')
                        // ->whereBetween('orders.created_at', ["$this->startDate","$this->currentDate"])
                        ->whereIn('orders.user_id', $userIds)
                        // ->groupBy('orders.user_id')
                        // ->get();
                        ->pluck('order_items.course_id', 'orders.user_id')->toArray();

        foreach ($failed_order_user as $order) {
            if (isset($complete_order[$order->user_id]) != $order->course_id) {
                $orderIds[] = $order->order_id;
            }
        }

        $data['failed_order_repeat_purchase'] = (count($failed_order_user) - count($orderIds));
        $data['failed_order_dont_purchase'] = count($orderIds);

        // // Failed Order List End

        return $data;
    }

    public function getNewTodayCatCourses($id) {
        // return DB::table('courses')
        //     ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(orders.id) as count,SUM(orders.total) as total_amount')
        //     ->join('order_items', 'order_items.course_id', 'courses.id')
        //     ->join('orders', 'orders.id', 'order_items.order_id')
        // // ->where('courses.show_on_menu', '=', 'yes')
        //     ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
        //     ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
        //     ->where('courses.status', '=', 'published')
        //     ->where('orders.payment_status', '=', 'completed')
        //     ->groupBy('course_id')
        // // ->orderBy('courses.sort_order')
        // // ->having('count', '>', '0')
        // // ->having('total_amount', '>', '0')
        //     ->get();

        return DB::table('orders')
                        ->selectRaw('courses.slug as course_slug, COUNT(orders.id) as count,SUM(orders.total) as total_amount')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('courses', 'courses.id', '=', 'order_items.course_id')
                        ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
                        // ->where('courses.show_on_menu', '=', 'yes')
                        ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
                        // ->where('courses.status', '=', 'published')
                        ->where('orders.payment_status', '=', 'completed')
                        ->where('course_categories.id', $id)
                        ->groupBy('course_id')
                        ->get();
    }

    public function getNewLastDayCatCourses($id) {
        // return DB::table('courses')
        //     ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(orders.id) as count,SUM(orders.total) as total_amount')
        //     ->join('order_items', 'order_items.course_id', 'courses.id')
        //     ->join('orders', 'orders.id', 'order_items.order_id')
        // // ->where('courses.show_on_menu', '=', 'yes')
        //     ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
        //     ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
        //     ->where('courses.status', '=', 'published')
        //     ->where('orders.payment_status', '=', 'completed')
        //     ->groupBy('course_id')
        // // ->orderBy('courses.sort_order')
        // // ->having('count', '>', '0')
        // // ->having('total_amount', '>', '0')
        //     ->get();

        return DB::table('orders')
                        ->selectRaw('courses.slug as course_slug, COUNT(orders.id) as count,SUM(orders.total) as total_amount')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('courses', 'courses.id', '=', 'order_items.course_id')
                        ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
                        // ->where('courses.show_on_menu', '=', 'yes')
                        ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
                        // ->where('courses.status', '=', 'published')
                        ->where('orders.payment_status', '=', 'completed')
                        ->where('course_categories.id', $id)
                        ->groupBy('course_id')
                        ->get();
    }

    public function getOldTodayCatCourses($id) {
        return DB::table('courses')
                        ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(old_orders.id) as count,SUM(old_orders.total_revenue) as total_amount')
                        ->join('old_orders', 'old_orders.name', 'courses.name')
                        // ->where('courses.show_on_menu', '=', 'yes')
                        ->whereBetween('old_orders.order_date', [$this->startDate, $this->endDate])
                        ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
                        // ->where('courses.status', '=', 'published')
                        ->groupBy('course_id')
                        ->orderBy('courses.sort_order')
                        ->get();
    }

    public function getOldLastDayCatCourses($id) {
        return DB::table('courses')
                        ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(old_orders.id) as count,SUM(old_orders.total_revenue) as total_amount')
                        ->join('old_orders', 'old_orders.name', 'courses.name')
                        // ->where('courses.show_on_menu', '=', 'yes')
                        ->whereBetween('old_orders.order_date', [$this->previousStartDate, $this->previousEndDate])
                        ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
                        // ->where('courses.status', '=', 'published')
                        ->groupBy('course_id')
                        ->orderBy('courses.sort_order')
                        ->get();
    }

    public function commonData($slug = null) {
        $data = $courseData = [];
        if ($slug) {
            $categories = DB::table('course_categories')->select('id')->where('slug', $slug)->first();
            $categories_id = isset($categories->id) ? $categories->id : null;
            if ($categories_id) {
                $courses = DB::table('courses')
                                // ->where('show_on_menu', 'yes')
                                ->whereRaw("FIND_IN_SET($categories_id, category_ids)")
                                // ->where('status', 'published')
                                ->orderBy('sort_order', 'asc')
                                ->pluck('name', 'slug')->toArray();

                $courses_slug = array_keys($courses);
                $courseData['selected_course'] = $slug;

                foreach ($courses_slug as $slug) {
                    $data['today_enrollment'][$slug] = 0;
                    $data['lastDay_enrollment'][$slug] = 0;
                    $data['today_revenue'][$slug] = 0;
                    $data['lastDay_revenue'][$slug] = 0;
                }
                // return $this->getNewTodayCatCourses($categories_id);
                foreach ($this->getNewTodayCatCourses($categories_id) as $course) {
                    $data['today_enrollment'][$course->course_slug] += $course->count;
                    $data['today_revenue'][$course->course_slug] += $course->total_amount;
                }

                // foreach ($this->getOldTodayCatCourses($categories_id) as $course) {
                //     $data['today_enrollment'][$course->course_slug] += $course->count;
                //     $data['today_revenue'][$course->course_slug] += $course->total_amount;
                // }

                foreach ($this->getNewLastDayCatCourses($categories_id) as $course) {
                    $data['lastDay_enrollment'][$course->course_slug] += $course->count;
                    $data['lastDay_revenue'][$course->course_slug] += $course->total_amount;
                }

                // foreach ($this->getOldLastDayCatCourses($categories_id) as $course) {
                //     $data['lastDay_enrollment'][$course->course_slug] += $course->count;
                //     $data['lastDay_revenue'][$course->course_slug] += $course->total_amount;
                // }

                foreach ($courses_slug as $key => $slug) {
                    if (($data['today_enrollment'][$slug] < 1) && ($data['today_revenue'][$slug] < 1) && ($data['lastDay_enrollment'][$slug] < 1) && ($data['lastDay_revenue'][$slug] < 1)) {
                        unset($data['today_enrollment'][$slug]);
                        unset($data['today_revenue'][$slug]);
                        unset($data['lastDay_enrollment'][$slug]);
                        unset($data['lastDay_revenue'][$slug]);
                        unset($courses[$slug]);
                    }
                }
                $courseData['today_enrollment'] = array_values($data['today_enrollment']);
                $courseData['today_revenue'] = array_values($data['today_revenue']);
                $courseData['lastDay_enrollment'] = array_values($data['lastDay_enrollment']);
                $courseData['lastDay_revenue'] = array_values($data['lastDay_revenue']);
                $courseData['courses_slug'] = array_keys($courses);

                $today_enrollment = array_sum($courseData['today_enrollment']);
                $today_revenue = array_sum($courseData['today_revenue']);
                $lastDay_enrollment = array_sum($courseData['lastDay_enrollment']);
                $lastDay_revenue = array_sum($courseData['lastDay_revenue']);

                // $courseDataTodayEnrollment = array_values($data['today_enrollment']);
                // $courseDataTodayRevenue = array_values($data['today_revenue']);
                // $courseDataLastDayEnrollment = array_values($data['lastDay_enrollment']);
                // $courseDataLastDayRevenue = array_values($data['lastDay_revenue']);
                // $today_enrollment = array_sum($courseDataTodayEnrollment);
                // $today_revenue = array_sum($courseDataTodayRevenue);
                // $lastDay_enrollment = array_sum($courseDataLastDayEnrollment);
                // $lastDay_revenue = array_sum($courseDataLastDayRevenue);
                // $courseData['today_enrollment'] = arrNumberFormat($courseDataTodayEnrollment);
                // $courseData['today_revenue'] = arrNumberFormat($courseDataTodayRevenue);
                // $courseData['lastDay_enrollment'] = arrNumberFormat($courseDataLastDayEnrollment);
                // $courseData['lastDay_revenue'] = arrNumberFormat($courseDataLastDayRevenue);

                $courseData['total_today_enrollment'] = numberFormat($today_enrollment);
                $courseData['total_today_revenue'] = numberFormat($today_revenue);

                $courseData['per_today_enrollment'] = round(min(($today_enrollment - $lastDay_enrollment) / ($lastDay_enrollment > 0 ? $lastDay_enrollment : 1) * 100, 100), 2);

                $courseData['per_today_revenue'] = round(min(($today_revenue - $lastDay_revenue) / ($lastDay_revenue > 0 ? $lastDay_revenue : 1) * 100, 100), 2);

                return $courseData;
            }
            return "Categories not found";
        }
        return 'Data Not Found';
    }

    public function revenueModel(Request $request) {
        $date = isset($request->date) ? $request->date : null;
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
        return view('Admin.CeoRevenue.revenueModel', ['startDate' => $this->startDate, 'endDate' => $this->endDate]);
    }

    public function getData(Request $request) {
        $userIds = $orderIds = [];
        $startDate = isset($request->startDate) ? $request->startDate : Carbon::now()->format('Y-m-d H:i:s');
        $endDate = isset($request->endDate) ? $request->endDate : Carbon::now()->format('Y-m-d H:i:s');

        $failed_order_user = DB::table('orders')
                ->selectRaw('orders.id as order_id,orders.user_id as user_id, order_items.course_id as course_id,order_items.id as order_item_id')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', ["$startDate", "$endDate"])
                ->whereIn('orders.payment_status', ['timeout', 'failed', 'pending'])
                // ->groupBy('orders.user_id', 'order_items.course_id')
                ->get();
        // ->pluck('orders.user_id')->toArray();

        foreach ($failed_order_user as $order) {
            $userIds[] = $order->user_id;
        }

        $complete_order = DB::table('orders')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->where('orders.payment_status', 'completed')
                        // ->whereBetween('orders.created_at', ["$this->startDate","$this->currentDate"])
                        ->whereIn('orders.user_id', $userIds)
                        ->pluck('order_items.course_id', 'orders.user_id')->toArray();

        foreach ($failed_order_user as $order) {
            if (isset($complete_order[$order->user_id]) != $order->course_id) {
                $orderIds[] = $order->order_id;
            }
        }

        $data = DB::table('orders')
                ->selectRaw('orders.id as order_id,orders.bd_name as name,orders.bd_email as email,orders.bd_phone_number as phone_number,order_items.name as course_name')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.id', $orderIds)
                ->orderByDesc('orders.created_at');

        return DataTables::of($data)
                        ->editColumn('name', function ($data) {
                            $name = "<p class='d-flex align-items-center'><img src='https://ui-avatars.com/api/?background=random&color=random&name=" . $data->name . "&size=512&rounded=true&format=svg' class='rounded-pill w-32px'> <span class='ms-1'>" . $data->name . "</span></p>";
                            return $name;
                        })
                        ->rawColumns(['name'])
                        ->addIndexColumn()
                        ->toJson();
    }

    public function getSalesData() {
        $conversionSource = [];

        // leads start
        $data['total_lead'] = DB::table('npf_webhooks')->whereBetween('urd', [$this->startDate, $this->endDate])->count();
        // $data['untouched_lead'] = DB::table('npf_webhooks')->whereBetween('urd', [$this->startDate, $this->endDate])->where('stage', 'Untouched')->count();

        $data['untouched_lead_list'] = DB::table('npf_webhooks')->selectRaw('count(lead_id) as count,owner')->whereBetween('urd', [$this->startDate, $this->endDate])->where('stage', 'Untouched')->groupBy('owner')->pluck('count', 'owner')->toArray();
        $data['untouched_lead'] = array_sum(array_values($data['untouched_lead_list']));

        if ($data['total_lead'] > 0) {
            $data['untouched_lead_per'] = round($data['untouched_lead'] * 100 / $data['total_lead'], 2);
        } else {
            $data['untouched_lead_per'] = 0;
        }
        //leads end
        // Converted leads start
        $orderCount = DB::table('orders')->join('order_items', 'order_items.order_id', '=', 'orders.id')->where('orders.payment_status', 'completed')->whereBetween('orders.created_at', [$this->startDate, $this->endDate])->count();
        $data['agent_base_leads'] = DB::table('npf_webhooks')->join('orders', 'orders.bd_phone_number', 'npf_webhooks.mobile')->whereNotNull('npf_webhooks.owner')->where('npf_webhooks.stage', 'Joined')->whereBetween('npf_webhooks.urd', [$this->startDate, $this->endDate])->whereBetween('orders.created_at', [$this->startDate, $this->endDate])->count();
        $data['direct_leads'] = $orderCount - $data['agent_base_leads'];
        $data['total_converted_leads'] = $orderCount;
        // Converted leads end
        // Conversion ratio start
        $conversionRatio = DB::table('npf_webhooks')->selectRaw('source')->groupBy('source')->pluck('source')->toArray();
        $data['conversionSource'] = $conversionRatio;
        foreach ($conversionRatio as $conversion) {
            $conversionSource['leads'][$conversion] = 0;
            $conversionSource['conversion_leads'][$conversion] = 0;
        }

        $totalLeads = DB::table('npf_webhooks')
                        ->selectRaw('count(lead_id) as total,source')
                        ->whereBetween('urd', [$this->startDate, $this->endDate])
                        ->groupBy('source')
                        ->orderByDesc('total')
                        // ->toSql();
                        ->pluck('total', 'source')->toArray();
        // return $totalLeads;
        foreach ($totalLeads as $key => $agent) {
            $conversionSource['leads'][$key] = $agent;
        }

        $conversionLeads = DB::table('npf_webhooks')
                        ->selectRaw('count(lead_id) as total,source')
                        ->whereBetween('urd', [$this->startDate, $this->endDate])
                        ->where('stage', 'Joined')
                        ->orderByDesc('total')
                        ->groupBy('source')
                        ->pluck('total', 'source')->toArray();

        foreach ($conversionLeads as $key => $agent) {
            $conversionSource['conversion_leads'][$key] = $agent;
        }

        $data['conversion_ratio_lead'] = array_values($conversionSource['leads']);
        $data['conversion_ratio_conversion_lead'] = array_values($conversionSource['conversion_leads']);

        return $data;
        //  Conversion ratio end
    }

    public function getCallsData($date = 'today') {

        #Total Calls
        $total_connected_calls = DB::table('ozonetel_webhook')
                ->where('Status', 'Answered')
                ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                ->count();
        $total_unanswered_calls = DB::table('ozonetel_webhook')
                ->where('Status', 'NotAnswered')
                ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                ->count();
        #Inbound Calls
        $inbound_calls = DB::table('ozonetel_webhook')
                ->selectRaw('SUM(CASE WHEN Type = "Inbound" THEN 1 ELSE 0 END) as total_inbound_calls')
                ->selectRaw('SUM(CASE WHEN Type = "Inbound" AND Status = "Answered" THEN 1 ELSE 0 END) as inbound_connected_calls')
                ->selectRaw('SUM(CASE WHEN Type = "Inbound" AND Status = "NotAnswered" THEN 1 ELSE 0 END) as inbound_unanswered_calls')
                ->selectRaw('SEC_TO_TIME(SUM(CASE WHEN Type = "Inbound" THEN (TIME_TO_SEC(Duration)) ELSE 0 END)) as inbound_duration_hours')
                ->selectRaw('ROUND(SUM(CASE WHEN Type = "Inbound" THEN (TIME_TO_SEC(Duration) % 3600) / 60 ELSE 0 END),0) as inbound_duration_minutes')
                ->selectRaw('COUNT(DISTINCT CASE WHEN Type = "Inbound" AND AgentUniqueID IS NOT NULL THEN AgentUniqueID ELSE NULL END) as inbound_agents')
                ->selectRaw('COUNT(CASE WHEN Type = "Inbound" AND FallBackRule LIKE "%Queue%" AND FallBackRule IS NOT NULL THEN FallBackRule ELSE NULL END) as calls_queue')
                ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                ->first();

        #Outbound Calls
        // $outbound_calls = DB::table('ozonetel_webhook')
        // ->selectRaw('SUM(CASE WHEN Type = "Manual" THEN 1 ELSE 0 END) as total_outbound_calls')
        // ->selectRaw('SUM(CASE WHEN Type = "Manual" AND Status = "Answered" THEN 1 ELSE 0 END) as outbound_connected_calls')
        // ->selectRaw('SUM(CASE WHEN Type = "Manual" AND Status = "NotAnswered" THEN 1 ELSE 0 END) as outbound_unanswered_calls')
        // ->selectRaw('ROUND(SUM(CASE WHEN Type = "Manual" THEN TIME_TO_SEC(TIMEDIFF(Duration, "00:00:00")) / 3600 ELSE 0 END), 2) as outbound_duration_hours')
        // ->selectRaw('SUM(CASE WHEN Type = "Manual" THEN FLOOR((TIME_TO_SEC(Duration) % 3600) / 60) ELSE 0 END) as outbound_duration_minutes')
        // // ->selectRaw('SUM(CASE WHEN Type = "Manual" THEN FLOOR(TIME_TO_SEC(TIMEDIFF(Duration, "00:00:00")) / 60) ELSE 0 END) as outbound_duration_minutes')
        // ->selectRaw('COUNT(DISTINCT CASE WHEN Type = "Manual" AND AgentUniqueID IS NOT NULL THEN AgentUniqueID ELSE NULL END) as outbound_agents')
        // ->whereBetween('StartTime', [$this->startDate, $this->endDate])
        // ->first();
        $outbound_calls = DB::table('ozonetel_webhook')
                ->selectRaw('SUM(CASE WHEN Type = "Manual" THEN 1 ELSE 0 END) as total_outbound_calls')
                ->selectRaw('SUM(CASE WHEN Type = "Manual" AND Status = "Answered" THEN 1 ELSE 0 END) as outbound_connected_calls')
                ->selectRaw('SUM(CASE WHEN Type = "Manual" AND Status = "NotAnswered" THEN 1 ELSE 0 END) as outbound_unanswered_calls')
                ->selectRaw('SEC_TO_TIME(SUM(CASE WHEN Type = "Manual" THEN (TIME_TO_SEC(Duration)) ELSE 0 END)) as outbound_duration_hours')
                ->selectRaw('ROUND(SUM(CASE WHEN Type = "Manual" THEN (TIME_TO_SEC(Duration) % 3600) / 60 ELSE 0 END),0) as outbound_duration_minutes')
                ->selectRaw('COUNT(DISTINCT CASE WHEN Type = "Manual" AND AgentUniqueID IS NOT NULL THEN AgentUniqueID ELSE NULL END) as outbound_agents')
                ->selectRaw('COUNT(CASE WHEN Type = "Manual" AND FallBackRule LIKE "%Queue%" AND FallBackRule IS NOT NULL THEN FallBackRule ELSE NULL END) as calls_queue')
                ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                ->first();
        #Progressive Calls
        $progressive_calls = DB::table('ozonetel_webhook')
                ->selectRaw('SUM(CASE WHEN Type = "Progressive" THEN 1 ELSE 0 END) as total_progressive_calls')
                ->selectRaw('SUM(CASE WHEN Type = "Progressive" AND Status = "Answered" THEN 1 ELSE 0 END) as progressive_connected_calls')
                ->selectRaw('SUM(CASE WHEN Type = "Progressive" AND Status = "NotAnswered" THEN 1 ELSE 0 END) as progressive_unanswered_calls')
                ->selectRaw('SEC_TO_TIME(SUM(CASE WHEN Type = "Progressive" THEN (TIME_TO_SEC(Duration)) ELSE 0 END)) as progressive_duration_hours')
                ->selectRaw('ROUND(SUM(CASE WHEN Type = "Progressive" THEN (TIME_TO_SEC(Duration) % 3600) / 60 ELSE 0 END),0) as progressive_duration_minutes')
                ->selectRaw('COUNT(DISTINCT CASE WHEN Type = "Progressive" AND AgentUniqueID IS NOT NULL THEN AgentUniqueID ELSE NULL END) as progressive_agents')
                ->selectRaw('COUNT(CASE WHEN Type = "Progressive" AND FallBackRule LIKE "%Queue%" AND FallBackRule IS NOT NULL THEN FallBackRule ELSE NULL END) as calls_queue')
                ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                ->first();

        #Call timing
        $day_time_of_calls = DB::table('ozonetel_webhook')
                // ->where('Status', 'Answered')
                // ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                // ->whereBetween('StartTime', [$this->startDate . ' 09:00:00', $this->endDate . ' 21:00:00'])
                ->where(function ($query) {
                    $query->whereDate('StartTime', '=', now()->toDateString())
                    ->whereTime('StartTime', '>=', '09:00:00')
                    ->whereTime('StartTime', '<=', '21:00:00');
                })
                ->count();



        $night_time_of_calls = DB::table('ozonetel_webhook')
                // ->where('Status', 'Answered')
                // ->whereBetween('StartTime', [$this->startDate, $this->endDate])
                // ->whereBetween('StartTime', [$this->startDate . ' 21:00:00', $this->endDate . ' 09:00:00'])
                ->where(function ($query) {
                    $query->whereDate('StartTime', '=', now()->toDateString())
                    ->whereTime('StartTime', '>=', '21:00:00')
                    ->whereTime('StartTime', '<=', '09:00:00');
                })
                ->count();
        // $day_time_of_calls = DB::table('ozonetel_webhook')
        // ->where('Status', 'Answered')
        // ->where(function($query) {
        //     $query->whereBetween('StartTime', [$this->startDate, $this->endDate])
        //           ->orWhereBetween('StartTime', [$this->startDate . ' 09:00:00', $this->endDate . ' 21:00:00']);
        // })
        // ->count();
        # Call Hour Flow
        if ($date == 'yesterday') {
            $startDates = now()->subDay()->setTime(9, 0, 0);
            $endDates = now()->subDay()->setTime(21, 0, 0);
        } elseif ($date == 'this_week') {
            $startDates = '0000-00-00 00:00:00';
            $endDates = '0000-00-00 00:00:00';
        } elseif ($date == 'last_month') {
            $startDates = '0000-00-00 00:00:00';
            $endDates = '0000-00-00 00:00:00';
        } elseif ($date == '3_months') {
            $startDates = '0000-00-00 00:00:00';
            $endDates = '0000-00-00 00:00:00';
        } elseif ($date == '6_months') {
            $startDates = '0000-00-00 00:00:00';
            $endDates = '0000-00-00 00:00:00';
        } elseif ($date == 'this_year') {
            $startDates = '0000-00-00 00:00:00';
            $endDates = '0000-00-00 00:00:00';
        } elseif ($date == 'last_year') {
            $startDates = '0000-00-00 00:00:00';
            $endDates = '0000-00-00 00:00:00';
        } else {
            $startDates = now()->setTime(9, 0, 0);
            $endDates = now()->setTime(21, 0, 0);
        }
        $total_calls_data = DB::table('ozonetel_webhook')
                ->selectRaw('HOUR(StartTime) as hour, COUNT(*) as call_count')
                // ->where('Status', 'Answered')
                ->whereBetween('StartTime', [$startDates, $endDates])
                ->groupBy(DB::raw('HOUR(StartTime)'))
                ->get();


        $total_missed_calls_data = DB::table('ozonetel_webhook')
                        ->selectRaw('COUNT(*) as call_count,HangupBy')
                        ->where('Status', 'NotAnswered')
                        ->whereBetween('StartTime', [$startDates, $endDates])
                        ->groupBy('HangupBy')
                        ->pluck('call_count', 'HangupBy')->toArray();

        // echo "<pre>";
        // print_r($total_missed_calls_data);
        // exit;


        $callData = [];
        $callHours = [];
        $call_graph_data = [];
        foreach ($total_calls_data as $key => $row) {
            $call_graph_data[$key]['call_count'] = $row->call_count;
            $call_graph_data[$key]['time'] = date('h A', strtotime($row->hour . ':00:00'));
        }

        // Custom function for sorting based on time
        function sortByTime($a, $b) {
            return strtotime($a['time']) - strtotime($b['time']);
        }

        // Sorting the array using the custom function
        // Sorting the array using an anonymous function
        usort($call_graph_data, function($a, $b) {
            return sortByTime($a, $b);
        });


        foreach ($call_graph_data as $item) {
            $callData[] = $item['call_count'];
        }

        foreach ($call_graph_data as $item) {
            $callHours[] = $item['time'];
        }






        // foreach ($callHour as $hour) {
        //     $hourLabels[] = date('h A', strtotime($hour . ':00:00'));
        // }
        $call_hour_flow_count = array_sum($callData);
        #Array
        $data = [
            'total_inbound_calls' => ($inbound_calls->total_inbound_calls == 0) ? 0 : $inbound_calls->total_inbound_calls,
            'inbound_connected_calls' => ($inbound_calls->inbound_connected_calls == 0) ? 0 : $inbound_calls->inbound_connected_calls,
            'inbound_unanswered_calls' => ($inbound_calls->inbound_unanswered_calls == 0) ? 0 : $inbound_calls->inbound_unanswered_calls,
            'inbound_duration_hours' => ($inbound_calls->inbound_duration_hours == 0) ? 0 : $inbound_calls->inbound_duration_hours,
            'inbound_duration_minutes' => ($inbound_calls->inbound_duration_minutes == 0) ? 0 : $inbound_calls->inbound_duration_minutes,
            'inbound_agents' => ($inbound_calls->inbound_agents == 0) ? 0 : $inbound_calls->inbound_agents,
            'inbound_calls_queue' => ($inbound_calls->calls_queue == 0) ? 0 : $inbound_calls->calls_queue,
            'total_outbound_calls' => ($outbound_calls->total_outbound_calls == 0) ? 0 : $outbound_calls->total_outbound_calls,
            'outbound_connected_calls' => ($outbound_calls->outbound_connected_calls == 0) ? 0 : $outbound_calls->outbound_connected_calls,
            'outbound_unanswered_calls' => ($outbound_calls->outbound_unanswered_calls == 0) ? 0 : $outbound_calls->outbound_unanswered_calls,
            'outbound_duration_hours' => ($outbound_calls->outbound_duration_hours == 0) ? 0 : $outbound_calls->outbound_duration_hours,
            'outbound_duration_minutes' => ($outbound_calls->outbound_duration_minutes == 0) ? 0 : $outbound_calls->outbound_duration_minutes,
            'outbound_agents' => ($outbound_calls->outbound_agents == 0) ? 0 : $outbound_calls->outbound_agents,
            'outbound_calls_queue' => ($outbound_calls->calls_queue == 0) ? 0 : $outbound_calls->calls_queue,
            'total_progressive_calls' => ($progressive_calls->total_progressive_calls == 0) ? 0 : $progressive_calls->total_progressive_calls,
            'progressive_connected_calls' => ($progressive_calls->progressive_connected_calls == 0) ? 0 : $progressive_calls->progressive_connected_calls,
            'progressive_unanswered_calls' => ($progressive_calls->progressive_unanswered_calls == 0) ? 0 : $progressive_calls->progressive_unanswered_calls,
            'progressive_duration_hours' => ($progressive_calls->progressive_duration_hours == 0) ? 0 : $progressive_calls->progressive_duration_hours,
            'progressive_duration_minutes' => ($progressive_calls->progressive_duration_minutes == 0) ? 0 : $progressive_calls->progressive_duration_minutes,
            'progressive_agents' => ($progressive_calls->progressive_agents == 0) ? 0 : $progressive_calls->progressive_agents,
            'progressive_calls_queue' => ($progressive_calls->calls_queue == 0) ? 0 : $progressive_calls->calls_queue,
            'total_connected_calls' => $total_connected_calls,
            'total_unanswered_calls' => $total_unanswered_calls,
            'day_time_of_calls' => $day_time_of_calls,
            'night_time_of_calls' => $night_time_of_calls,
            'call_hour_flow' => $callData,
            'call_hour_flow_count' => $call_hour_flow_count,
            'call_hour_get' => $callHours,
            'total_missed_calls_data' => $total_missed_calls_data,
        ];
        return $data;
    }

    public function perAgentConversion(Request $request) {
        // $data = DB::table('npf_webhooks')->select('npf_webhooks.owner', DB::raw('count(npf_webhooks.stage) as leads'), DB::raw('SUM(npf_webhooks.stage = "Joined") as converted'), DB::raw('SUM(npf_webhooks.stage = "Untouched") as untouched'))->join('orders', 'orders.bd_phone_number', 'npf_webhooks.mobile')->whereNotNull('npf_webhooks.owner')->whereBetween('npf_webhooks.created_at', [$request->startDate, $request->endDate])->groupBy('npf_webhooks.owner')->get();
        // $data = DB::table('npf_webhooks')->select('npf_webhooks.owner', DB::raw('count(npf_webhooks.stage) as leads'), DB::raw('count(orders.id) as converted'), DB::raw('SUM(npf_webhooks.stage = "Untouched") as untouched'))->join('orders', 'orders.bd_phone_number', 'npf_webhooks.mobile')->whereNotNull('npf_webhooks.owner')->whereBetween('npf_webhooks.created_at', [$request->startDate, $request->endDate])->whereBetween('orders.created_at', [$request->startDate, $request->endDate])->groupBy('npf_webhooks.owner')->get();

        $orderJoinRecord = DB::table('npf_webhooks')->select('npf_webhooks.owner as owner', DB::raw('count(orders.id) as converted'))->join('orders', 'orders.bd_phone_number', 'npf_webhooks.mobile')->whereNotNull('npf_webhooks.owner')->where('npf_webhooks.stage', 'Joined')->whereBetween('npf_webhooks.urd', [$request->startDate, $request->endDate])->whereBetween('orders.created_at', [$request->startDate, $request->endDate])->groupBy('npf_webhooks.owner')->pluck('converted', 'owner')->toArray();

        $npfRecord = DB::table('npf_webhooks')->select('owner', DB::raw('count(stage) as leads'), DB::raw('SUM(npf_webhooks.stage = "Joined") as converted'), DB::raw('SUM(stage = "Untouched") as untouched'))->whereNotNull('owner')->groupBy('npf_webhooks.owner')->whereBetween('urd', [$request->startDate, $request->endDate])->get();
        // $npfRecord = DB::table('npf_webhooks')
        // ->select('owner', 'name', DB::raw('count(stage) as leads'), DB::raw('SUM(stage = "Joined") as converted'), DB::raw('SUM(stage = "Untouched") as untouched'))
        // ->whereNotNull('owner')
        // ->groupBy('owner', 'name')
        // ->whereBetween('urd', [$request->startDate, $request->endDate])
        // ->get();
        // $npfRecord = DB::table('npf_webhooks')
        // ->select('owner', DB::raw('count(stage) as leads'), DB::raw('SUM(npf_webhooks.stage = "Joined") as converted'), DB::raw('SUM(stage = "Untouched") as untouched'))
        // ->whereNotNull('owner')
        // ->groupBy('npf_webhooks.owner')
        // ->whereBetween('urd', [$request->startDate, $request->endDate])->get();
        foreach ($npfRecord as $npf) {
            if (array_key_exists($npf->owner, $orderJoinRecord)) {
                $npf->converted = $orderJoinRecord[$npf->owner];
            } else {
                $npf->converted = 0;
            }
        }
        // echo "<pre>";
        // print_r( $data);
        // exit;
        // foreach ($npfRecord as $key => $npfRecords) {
        //     $totalCallDurationInMinutes = 0;
        //     $calls = DB::table('ozonetel_webhook')
        //         ->select('Duration')
        //         ->where('AgentName', $npfRecords->owner)
        //         ->whereBetween('StartTime', [$request->startDate, $request->endDate])
        //         ->get();
        //     foreach ($calls as $call) {
        //         $durationParts = explode(":", $call->Duration);
        //         if (count($durationParts) >= 3) {
        //             $hours = intval($durationParts[0]);
        //             $minutes = intval($durationParts[1]);
        //             $seconds = intval($durationParts[2]);
        //             $totalCallDurationInMinutes += ($hours * 60) + $minutes + ($seconds / 60);
        //         }
        //     }
        //     $npfRecords->duration = round($totalCallDurationInMinutes,0);
        // }

        foreach ($npfRecord as $key => $npfRecords) {
            $totalCallDurationInMinutes = 0;
            $calls = DB::table('ozonetel_webhook')
                    ->select('Duration')
                    ->where('AgentName', 'like', '%' . $npfRecords->owner . '%')
                    ->whereNotNull('Duration')
                    ->whereBetween('StartTime', [$request->startDate, $request->endDate])
                    ->get();
            // foreach ($calls as $call) {
            //     $duration = \DateTime::createFromFormat('H:i:s', $call->Duration);
            //     if ($duration) {
            //         $totalCallDurationInMinutes += ($duration->format('H') * 60) + $duration->format('i');
            //     }
            // }
            foreach ($calls as $call) {
                $durationParts = explode(":", $call->Duration);
                if (count($durationParts) == 3) {
                    $totalCallDurationInMinutes += $durationParts[0] * 60 + $durationParts[1] + $durationParts[2] / 60;
                }
            }
            $npfRecords->duration = floor($totalCallDurationInMinutes);
        }



        foreach ($npfRecord as $key => $npf_record) {
            $total_calls = DB::table('ozonetel_webhook')
                    ->where('AgentName', 'like', "%" . $npf_record->owner . '%')
                    ->whereBetween('StartTime', [$request->startDate, $request->endDate])
                    ->count();
            $connected_calls = DB::table('ozonetel_webhook')
                    ->where('AgentName', 'like', "%" . $npf_record->owner . '%')
                    ->where('Status', 'Answered')
                    ->whereBetween('StartTime', [$request->startDate, $request->endDate])
                    ->count();
            $disconnected_calls = DB::table('ozonetel_webhook')
                    ->where('AgentName', 'like', "%" . $npf_record->owner . '%')
                    ->where('Status', 'NotAnswered')
                    ->whereBetween('StartTime', [$request->startDate, $request->endDate])
                    ->count();
            if ($total_calls > 0) {
                $connected_calls_per = $connected_calls / $total_calls * 100;

                $disconnected_calls_per = $disconnected_calls / $total_calls * 100;
                // $disconnected_calls = $disconnected_calls;
            } else {
                $connected_calls_per = 0;
                $disconnected_calls_per = 0;
            }
            $npf_record->connected_calls = round($connected_calls, 2);
            $npf_record->disconnected_calls = round($disconnected_calls, 2);

            $npf_record->connected_calls_per = $connected_calls_per;
            $npf_record->disconnected_calls_per = $disconnected_calls_per;
        }

        return DataTables::of($npfRecord)
                        ->addColumn('other_leads', function ($data) {
                            $sum = $data->leads - ((int) $data->converted + (int) $data->untouched);
                            // if ($sum > 0) {
                            //     return $sum;
                            // } elseif ($sum < 0) {
                            //     return 0;
                            // }
                            return $sum;
                        })
                        ->editColumn('untouched', function ($data) {
                            return '<span class="text-danger">' . $data->untouched . '</span>';
                        })
                        ->addColumn('talk_time', function ($data) {
                            return $data->duration . " Min";
                        })
                        ->addColumn('progress', function ($data) {
                            return '<div class="progress mb-1 h-16px">
                            <div class="progress-bar bg-primary-2" style="width: ' . $data->disconnected_calls_per . '%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="20">
                                    <span class="text-primary">' . $data->disconnected_calls . '</span>
                                </div>
                            </div>
                            <div class="progress h-16px">
                                <div class="progress-bar bg-primary" style="width: ' . $data->connected_calls_per . '%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="20">
                                    <span>' . $data->connected_calls . '</span>
                                </div>
                            </div>
                        </div>';
                        })
                        ->rawColumns(['other_leads', 'talk_time', 'progress', 'untouched'])
                        ->addIndexColumn()
                        ->toJson();
    }

}
