<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
                $sales = $this->getSalesData();
                // return json_encode($sales);
                return view('Admin.CeoRevenue.sales', ['sales' => $sales, 'startDate' => $this->startDate, 'endDate' => $this->endDate]);
            } elseif ($course == 'cat') {
                // $cat = $this->getCATData();
                $commonGraph = $this->commonData('cat');
                // return json_encode($commonGraph);
                return view('Admin.CeoRevenue.commonGraph', compact('commonGraph'));
            } elseif ($course == 'non_cat') {
                // $nonCat = $this->getNonCATData();
                $commonGraph = $this->commonData('non-cat');
                // return json_encode($nonCat);
                return view('Admin.CeoRevenue.commonGraph', compact('commonGraph'));
            } elseif ($course == 'study_abroad') {
                // $studyAbroad = $this->getStudyAbroadData();
                $commonGraph = $this->commonData('study-abroad');
                // return json_encode($commonGraph);
                return view('Admin.CeoRevenue.commonGraph', compact('commonGraph'));
            } elseif ($course == 'undergrad') {
                // $undergrad = $this->getUnderGradData();
                $commonGraph = $this->commonData('undergrad');
                // return json_encode($undergrad);
                return view('Admin.CeoRevenue.commonGraph', compact('commonGraph'));
            } elseif ($course == 'gdpi') {
                // $gdpi = $this->getGDPIData();
                $commonGraph = $this->commonData('gdpi');
                // return json_encode($gdpi);
                return view('Admin.CeoRevenue.commonGraph', compact('commonGraph'));
            } elseif ($course == 'mocks') {
                // $mocks = $this->getMocksData();
                $commonGraph = $this->commonData('mocks');
                // return json_encode($mocks);
                return view('Admin.CeoRevenue.commonGraph', compact('commonGraph'));
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

    public function getRevenueData()
    {
        $failed_order_repeat_purchase = $perviousOrderCount = 0;
        $failedOrderItemIDs = $data = $courses = $countData = $userIds = $complete_order = $orderIds = [];

        // This Year :: total No of enrollment start
        $new_order_today = DB::table('orders')
            ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'completed')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->first();

        $old_order_today = DB::table('old_orders')->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')->whereBetween('order_date', [$this->startDate, $this->endDate])->first();

        $data['this_year_total_enrollments'] = $new_order_today->count + $old_order_today->count;
        $data['this_year_total_revenue'] = ($new_order_today->total_amount + $old_order_today->total_amount);
        // This Year :: total No of enrollment end

        // Last Year :: total No of enrollment start
        $new_last_year_total = DB::table('orders')
            ->selectRaw('COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'completed')
            ->whereBetween('orders.created_at', [$this->lastStartDate, $this->lastEndDate])
            ->first();
        // $new_last_year_total = DB::table('orders')->selectRaw('COUNT(id) as count,SUM(total) as total_amount')->where('payment_status', 'completed')->whereBetween('created_at', [$this->lastStartDate, $this->lastEndDate])->first();

        $old_last_year_total = DB::table('old_orders')->selectRaw('COUNT(id) as count,SUM(total_revenue) as total_amount')->whereBetween('order_date', [$this->lastStartDate, $this->lastEndDate])->first();

        $data['last_year_total_enrollments'] = $new_last_year_total->count + $old_last_year_total->count;
        $data['last_year_total_revenue'] = (int) ($new_last_year_total->total_amount + $old_last_year_total->total_amount);
        // $data['last_year_total_revenue'] = $lastYearTotalRevenue != 0 ? $lastYearTotalRevenue : 1;
        // Last Year :: total No of enrollment end

        // Enrollment Per start
        $data['this_year_total_enrollments_per'] = perFindValue($data['this_year_total_enrollments'], $data['last_year_total_enrollments']);
        $data['last_year_total_enrollments_per'] = perFindValue($data['last_year_total_enrollments'], $data['this_year_total_enrollments']);
        $data['this_year_total_revenue_per'] = perFindValue($data['this_year_total_revenue'], $data['last_year_total_revenue']);
        $data['last_year_total_revenue_per'] = perFindValue($data['last_year_total_revenue'], $data['this_year_total_revenue']);
        $data['total_revenue_per'] = perFindAvg($data['this_year_total_revenue'], $data['last_year_total_revenue']);
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
        // return $new_this_year_emi_enrollments;
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
            ->join('courses', 'courses.id', '=', 'order_items.course_id')
            ->whereBetween('orders.created_at', [$this->lastStartDate, $this->lastEndDate])
            ->where(function ($q) {
                $q->where('courses.name', 'like', '%installment%')
                    ->orWhere('courses.name', 'like', '%emi%');
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
        $data['this_year_emi_enrollments_per'] = perFindValue($data['this_year_emi_enrollments'], $data['last_year_emi_enrollments']);
        $data['last_year_emi_enrollments_per'] = perFindValue($data['last_year_emi_enrollments'], $data['this_year_emi_enrollments']);
        $data['this_year_emi_revenue_per'] = perFindValue($data['this_year_emi_revenue'], $data['last_year_emi_revenue']);
        $data['last_year_emi_revenue_per'] = perFindValue($data['last_year_emi_revenue'], $data['this_year_emi_revenue']);
        $data['total_emi_revenue_per'] = perFindAvg($data['this_year_emi_revenue'], $data['last_year_emi_revenue']);
        // Enrollment through Installments & EMI end

        // Total No of enrollment Chart And Table start
        $course_categories = DB::table('course_categories')->select('name', 'slug')->get();
        foreach ($course_categories as $course) {
            $countData['enrollment'][$course->slug] = 0;
            $countData['today_day_total_revenue'][$course->slug] = 0;
            $countData['previous_day_total_revenue'][$course->slug] = 0;
            $courses[] = $course->name;
        }

        $data['course_name'] = $courses;

        $new_today_orders = DB::table('orders')
            ->selectRaw('course_categories.slug as course_category_slug, count(orders.id) as order_count,sum(orders.total) as total_revenue')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('courses', 'courses.id', '=', 'order_items.course_id')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->where('orders.payment_status', 'completed')
            ->groupBy('course_categories.slug')
            ->orderByDesc('order_count')
            ->get();

        $old_today_orders = DB::table('old_orders')
            ->selectRaw('course_categories.slug as course_category_slug, count(old_orders.id) as order_count,sum(old_orders.total_revenue) as total_revenue')
            ->join('courses', 'courses.name', '=', 'old_orders.name')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('old_orders.order_date', [$this->startDate, $this->endDate])
            ->groupBy('course_categories.slug')
            ->orderByDesc('order_count')
            ->get();
        // return $old_today_orders;
        $new_previous_orders = DB::table('orders')
            ->selectRaw('course_categories.slug as course_category_slug, count(orders.id) as order_count,sum(orders.total) as total_revenue')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('courses', 'courses.id', '=', 'order_items.course_id')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
            ->where('orders.payment_status', 'completed')
            ->groupBy('course_categories.slug')
        // ->pluck('total_revenue', 'course_category_slug')
        // ->toArray();
            ->get();

        $old_previous_orders = DB::table('old_orders')
            ->selectRaw('course_categories.slug as course_category_slug,count(old_orders.id) as order_count,sum(old_orders.total_revenue) as total_revenue')
            ->join('courses', 'courses.name', '=', 'old_orders.name')
            ->join('course_categories', 'course_categories.id', '=', 'courses.category_ids')
            ->whereBetween('old_orders.order_date', [$this->previousStartDate, $this->previousStartDate])
            ->groupBy('course_categories.slug')
        // ->pluck('total_revenue', 'course_category_slug')->toArray();
            ->get();

        foreach ($new_today_orders as $order) {
            $countData['enrollment'][$order->course_category_slug] += $order->order_count;
            $countData['today_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        }
        // return $new_today_orders;
        foreach ($old_today_orders as $order) {
            $countData['enrollment'][$order->course_category_slug] += $order->order_count;
            $countData['today_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        }
        // return $new_previous_orders;
        foreach ($new_previous_orders as $order) {
            $perviousOrderCount += $order->order_count;
            $countData['previous_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        }

        foreach ($old_previous_orders as $order) {
            $perviousOrderCount += $order->order_count;
            $countData['previous_day_total_revenue'][$order->course_category_slug] += $order->total_revenue;
        }

        //revenue chart start
        $data['today_revenue'] = array_values($countData['today_day_total_revenue']);
        $data['previous_day_revenue'] = array_values($countData['previous_day_total_revenue']);
        $todayTotalRevenue = array_sum($data['today_revenue']);
        $data['total_today_revenue'] = numberFormat($todayTotalRevenue);
        $data['total_per_revenue'] = perFindAvg($todayTotalRevenue, array_sum($data['previous_day_revenue']));
        //revenue chart end

        //pie chart start
        $totalOrderCount = array_sum($countData['enrollment']);
        $data['enrollment_per_avg'] = perFindAvg($totalOrderCount, $perviousOrderCount);
        foreach ($countData['enrollment'] as $key => $order) {
            $countData['enrollment_per'][$key] = $countData['enrollment'][$key] != 0 ? round(($countData['enrollment'][$key] / $totalOrderCount * 100), 2) : 0;
        }
        $data['enrollment_max'] = max(array_values($countData['enrollment_per']));
        $data['enrollment_per'] = $countData['enrollment_per'];
        $data['leads'] = $countData['enrollment'];
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

    public function getNewTodayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.course_id', 'courses.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->where('orders.payment_status', '=', 'completed')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }

    public function getNewLastDayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(orders.id) as count,SUM(orders.total) as total_amount')
            ->join('order_items', 'order_items.course_id', 'courses.id')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('orders.created_at', [$this->previousStartDate, $this->previousEndDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->where('orders.payment_status', '=', 'completed')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }

    public function getOldTodayCatCourses($id)
    {
        return DB::table('courses')
            ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(old_orders.id) as count,SUM(old_orders.total_revenue) as total_amount')
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
            ->selectRaw('courses.id as course_id,courses.slug as course_slug,COUNT(old_orders.id) as count,SUM(old_orders.total_revenue) as total_amount')
            ->join('old_orders', 'old_orders.name', 'courses.name')
            ->where('courses.show_on_menu', '=', 'yes')
            ->whereBetween('old_orders.order_date', [$this->previousStartDate, $this->previousEndDate])
            ->whereRaw("FIND_IN_SET($id, courses.category_ids)")
            ->where('courses.status', '=', 'published')
            ->groupBy('course_id')
            ->orderBy('courses.sort_order')
            ->get();
    }

    public function commonData($slug = null)
    {
        $data = $courseData = [];
        if ($slug) {
            $categories = DB::table('course_categories')->select('id')->where('slug', $slug)->first();
            $categories_id = isset($categories->id) ? $categories->id : null;
            if ($categories_id) {
                $courses = DB::table('courses')
                    ->where('show_on_menu', 'yes')
                    ->whereRaw("FIND_IN_SET($categories_id, category_ids)")
                    ->where('status', 'published')
                    ->orderBy('sort_order', 'asc')
                    ->pluck('name', 'slug')->toArray();

                $courses_slug = array_keys($courses);
                $courseData['courses_name'] = array_values($courses);
                $courseData['courses_slug'] = $courses_slug;
                $courseData['selected_course'] = $slug;

                foreach ($courses_slug as $slug) {
                    $data['today_enrollment'][$slug] = 0;
                    $data['lastDay_enrollment'][$slug] = 0;
                    $data['today_revenue'][$slug] = 0;
                    $data['lastDay_revenue'][$slug] = 0;
                }

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

                $courseData['today_enrollment'] = array_values($data['today_enrollment']);
                $courseData['today_revenue'] = array_values($data['today_revenue']);
                $courseData['lastDay_enrollment'] = array_values($data['lastDay_enrollment']);
                $courseData['lastDay_revenue'] = array_values($data['lastDay_revenue']);

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

    public function revenueModel(Request $request)
    {
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

    public function getData(Request $request)
    {
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

    public function getSalesData()
    {
        $conversionSource = [];

        // leads start
        $data['total_lead'] = DB::table('npf_webhooks')->whereBetween('urd', [$this->startDate, $this->endDate])->count();
        $data['untouched_lead'] = DB::table('npf_webhooks')->whereBetween('urd', [$this->startDate, $this->endDate])->where('stage', 'Untouched')->count();
        if ($data['total_lead'] > 0) {
            $data['untouched_lead_per'] = round($data['untouched_lead'] * 100 / $data['total_lead'], 2);
        } else {
            $data['untouched_lead_per'] = 0;
        }
        //leads end

        // Converted leads start
        $orderCount = DB::table('orders')->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $data['agent_base_leads'] = DB::table('npf_webhooks')->join('orders', 'orders.bd_phone_number', 'npf_webhooks.mobile')->whereBetween('npf_webhooks.urd', [$this->startDate, $this->endDate])->count();
        $data['direct_leads'] = $orderCount - $data['agent_base_leads'];
        // return $data;
        // Converted leads end

        // Conversion ratio start
        $conversionRatio = DB::table('npf_webhooks')->selectRaw('source')->groupBy('source')->pluck('source')->toArray();
        $data['conversionSource'] = $conversionRatio;
        foreach ($conversionRatio as $conversion) {
            $conversionSource['leads'][$conversion] = 0;
            $conversionSource['conversion_leads'][$conversion] = 0;
        }

        $agentBase = DB::table('npf_webhooks')
            ->selectRaw('count(npf_webhooks.lead_id) as total,npf_webhooks.source as source')
            ->whereBetween('npf_webhooks.urd', [$this->startDate, $this->endDate])
            ->groupBy('npf_webhooks.source')
            ->pluck('total', 'source')->toArray();

        foreach ($agentBase as $key => $agent) {
            $conversionSource['leads'][$key] = $agent;
        }

        $conversionLeads = DB::table('npf_webhooks')
            ->selectRaw('count(npf_webhooks.lead_id) as total,npf_webhooks.source as source')
            ->whereBetween('npf_webhooks.urd', [$this->startDate, $this->endDate])
            ->where('stage', 'Joined')
            ->groupBy('npf_webhooks.source')
            ->pluck('total', 'source')->toArray();

        foreach ($conversionLeads as $key => $agent) {
            $conversionSource['conversion_leads'][$key] = $agent;
        }

        $data['conversion_ratio_lead'] = array_values($conversionSource['leads']);
        $data['conversion_ratio_conversion_lead'] = array_values($conversionSource['conversion_leads']);

        return $data;
        //  Conversion ratio end
    }

    public function perAgentConversion(Request $request)
    {
        $data = DB::table('npf_webhooks')->select('owner', DB::raw('count(stage) as leads'), DB::raw('SUM(stage = "Joined") as joined'), DB::raw('SUM(stage = "Untouched") as untouched'))->whereNotNull('owner')->groupBy('owner')->get();

        return DataTables::of($data)
            ->addColumn('other_leads', function ($data) {
                return $data->leads - ((int) $data->joined + (int) $data->untouched);
            })
            ->editColumn('untouched', function ($data) {
                return '<span class="text-danger">' . $data->untouched . '</span>';
            })
            ->addColumn('talk_time', function ($data) {
                return "0 Min";
            })
            ->addColumn('progress', function ($data) {
                return '<div class="progress mb-1 h-16px">
                            <div class="progress-bar bg-primary-2" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="20">
                                    <span class="text-primary">0%</span>
                                </div>
                            </div>
                            <div class="progress h-16px">
                                <div class="progress-bar bg-primary" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="20">
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['other_leads', 'talk_time', 'progress', 'untouched'])
            ->addIndexColumn()
            ->toJson();
    }
}
