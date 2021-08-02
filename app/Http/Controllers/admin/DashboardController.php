<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Purchase;

use App\Models\Product;

use App\Models\RatingReview;

use App\Models\role;

use DB;



class DashboardController extends Controller
{
    
    //Constructer for specifying a middleware of roles and permission
    public function __construct()
    {
        $this->middleware('permission:View Dashboard',['only'=>['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = Purchase::selectraw("DATE_FORMAT(`created_at`, '%M-%Y') as date ")->groupBy('date')->get();

        $monthArray = array();

        $RecentRating = RatingReview::with('user')->latest()->take(4)->get();

        $TotalOrders = Purchase::count();

        $TotalSales = Purchase::sum('total_amt');
        
        $TotalDeliverdOrders = Purchase::where('delivery_status','Delivered')->count();

        $TotalNewOrders = Purchase::where('delivery_status','Ordered')->count();

        $RecentProducts = Product::latest()->take(4)->get();         

        // dd($TotalSales); 
        
        foreach($orders as $order)
        {
            array_push($monthArray,$order->date);
        }
         // $months = array_unique($months);

        // dd($monthArray);

        return view('backend.dashboard.index',compact('monthArray','RecentRating','TotalOrders','TotalSales','TotalNewOrders','TotalDeliverdOrders','RecentProducts'));
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

    public function ajax(Request $request)
    {
        //convert string into array like july-2020 to july as 0 or 2020 to 1
        $month_year=explode('-',$request->month_year);

       


        if($request->ajax() && $request->chart_type == 'order chart')
        {
            //get order details date as x and y as total order for a chart and get data as per select month and year

             // DB::enableQueryLog();
            $order = Purchase::select(DB::raw('DATE_FORMAT(`created_at`,"%d %M %Y") as x'),DB::raw('Count(*) as y '))
            ->groupBy('x')
            ->whereYear('created_at',$month_year[1])
            ->whereMonth('created_at',$month_year[0])
            ->get();
            // dd(DB::getQueryLog());
            // dd($order);
            return Response()->json(['order' => $order ]);
        }
        
        elseif($request->ajax() && $request->chart_type == 'user chart')
        {
                $users = role::select('roles.name')
                ->withCount('user')
                ->where('name','!=','SuperAdmin')
                ->get(); 

                return Response()->json(['user'=>$users]);

        }
    }
}
