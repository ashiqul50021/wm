<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\PosOrder;
use App\Models\OrderDetail;
use App\Models\ProductStock;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('78', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $sort_by = null;
            $products = Product::orderBy('created_at', 'desc');
            $categories = Category::where('id', $request->category_id)->select('id', 'name_en')->first();

            if (Auth::guard('admin')->user()->role == '2') {
                $products = Product::orderBy('created_at', 'desc')->where('vendor_id', Auth::guard('admin')->user()->id);

                if ($request->has('category_id')) {
                    $sort_by = $request->category_id;
                    $products = $products->where('category_id', $sort_by);
                }

                $vendor = Vendor::where('user_id', Auth::guard('admin')->user()->id)->first();

                if ($vendor) {
                    $products = Product::where('vendor_id', $vendor->id)->latest()->get();
                }
            } else {
                if ($request->has('category_id')) {
                    $sort_by = $request->category_id;
                    $products = $products->where('category_id', $sort_by, $categories);
                }
            }

            $products = $products->get();

            return view('backend.reports.index', compact('products', 'categories'));
        }
        else{
            Session::flash('error', 'You have no Access to visit the page');
            return back();
        }
    }

    public function saleReport()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('79', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $posOrder = PosOrder::latest()->get();
            return view('backend.reports.sale_report', compact('posOrder'));
        }
        else{
            Session::flash('error', 'You have no permission to Visit the Page');
            return back();
        }
    }
    public function OrderSaleReport()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('5201', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $order = Order::latest()->get();
            return view('backend.reports.order_sale_report', compact('order'));
        }
        else{
            Session::flash('error', 'You have no permission to Visit the Page');
            return back();
        }
    }
    public function searchBySaleReport(Request $request)
    {
        $posOrder = PosOrder::when($request->has('date'), function ($query) use ($request) {
            $dateRange = explode(" - ", $request->input('date'));
            $startDate = Carbon::createFromFormat('d-m-Y', $dateRange[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d-m-Y', $dateRange[1])->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->get();

        return view('backend.reports.sale_report', compact('posOrder'));
    }
    public function searchByAllOrderSaleReport(Request $request)
    {
        $order = Order::when($request->has('date'), function ($query) use ($request) {
            $dateRange = explode(" - ", $request->input('date'));
            $startDate = Carbon::createFromFormat('d-m-Y', $dateRange[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d-m-Y', $dateRange[1])->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->get();

        return view('backend.reports.order_sale_report', compact('order'));
    }


    public function profitReport()
    {
        $currentMonth = Carbon::now()->month;
        $order_today_total  = Order::whereDay('created_at', date('d'))->sum('grand_total');
        $order_today_pur  = Order::whereDay('created_at', date('d'))->sum('pur_sub_total');
        $order_today_shipping  = Order::whereDay('created_at', date('d'))->sum('shipping_charge');
        $today_profit = (($order_today_total - $order_today_shipping) - $order_today_pur);

        $order_monthly_total = Order::whereMonth('created_at', $currentMonth)->sum('grand_total');
        $order_monthly_pur = Order::whereMonth('created_at', $currentMonth)->sum('pur_sub_total');
        $order_monthly_shipping = Order::whereMonth('created_at', $currentMonth)->sum('shipping_charge');
        $monthly_profit = (($order_monthly_total - $order_monthly_shipping) - $order_monthly_pur);

        $order_yearly_total  = Order::whereYear('created_at', date('Y-m-d'))->sum('grand_total');
        $order_yearly_pur  = Order::whereYear('created_at', date('Y-m-d'))->sum('pur_sub_total');
        $order_yearly_shipping  = Order::whereYear('created_at', date('Y-m-d'))->sum('shipping_charge');
        $yearly_profit = (($order_monthly_total - $order_yearly_shipping) - $order_monthly_pur);

        return view('backend.reports.profit_report', compact('today_profit', 'monthly_profit', 'yearly_profit',));
    }
    public function showOrderProfitReport(){
        $profitData = Order::with('order_Detail')
        ->where('delivery_status', 'delivered')
        ->latest()
        ->get();
        return view('backend.reports.all-order-profit-report',compact('profitData'));
    }
    // public function showPosOrderProfitReport(){
    //     $PosProfitData = [];
    //     return view('backend.reports.pos-order-profit-report',compact('PosProfitData'));
    // }

    public function allOrderProfitReport(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $profitData = Order::with('order_Detail')
        ->where('delivery_status', 'delivered')
        ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
        ->latest()
        ->get();
        // dd($profitData);
        return view('backend.reports.all-order-profit-report', compact('profitData'));
    }

    public function showPosOrderProfitReport(){
        $PosProfitData = PosOrder::with('posOrderItem')
        ->latest()
        ->get();
        return view('backend.reports.pos-order-profit-report', compact('PosProfitData'));
    }
    public function posOrderProfitReport(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $PosProfitData = PosOrder::with('posOrderItem')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->get();


        return view('backend.reports.pos-order-profit-report', compact('PosProfitData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
