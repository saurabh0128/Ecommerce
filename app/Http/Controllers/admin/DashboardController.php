<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\Purchase;


use App\Models\Product;

use App\Models\RatingReview;


use App\Models\User;

use App\Models\role;
use DB;
use App\Http\Controllers\DateTime;
use Carbon\carbon;

use Illuminate\Notifications\DatabaseNotification;

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

        if($request->ajax()){
            if($request->chart_type == 'order chart')
            {
                $month_year=explode('-',$request->month_year);
                
                //get order details date as x and y as total order for a chart and get data as per select month and year
               $order = Purchase::select(DB::raw('DATE_FORMAT(`created_at`,"%d %M %Y") as x'),DB::raw('Count(*) as y '))
                ->groupBy('x')
                ->whereYear('created_at',$month_year[1])
                ->whereMonth('created_at',$month_year[0])
                ->get();
                
                return Response()->json(['order' => $order ]);
            }elseif($request->notification_read == 'read'){
                
                //for notification       
                $userUnreadNotification = auth()->user()->unreadNotifications->where('id', $request->notification_id)->first();   

                if($userUnreadNotification){
                    $userUnreadNotification->update(['read_at' => now()]);;   
                }
                
                //count all unread notification 
                $notification_counter = auth()->user()->unreadNotifications()->groupBy('notifiable_type')->count();

                //all unread notification get
                $user = User::find(auth()->user()->id);
                $all_notification = "";
                $all_notification_data = "";
                foreach($user->unreadNotifications as $notification){
                    $all_notification_data = Carbon::parse($notification->created_at)->diffForHumans();
                    $all_notification .= "<a notification-id='".$notification->id."' class='d-flex' id='read-noti'>
                                        <div class='flex-shrink-0'>
                                            <figure class='avatar avatar-info me-3'>
                                                    <span class='avatar-text rounded-circle'>
                                                        <i class='bi bi-".$notification->data[1]."'></i>
                                                    </span>
                                            </figure>
                                        </div>
                                         <div class='flex-grow-1'>
                                            <p class='mb-0 fw-bold d-flex justify-content-between'>
                                                ".$notification->data[0]."
                                            </p>
                                            <span class='text-muted small'>
                                                <i class='bi bi-clock me-1'></i>".$all_notification_data."
                                            </span>
                                        </div></a></br>"; 
                }
                
                return Response()->json(["notification_count" => $notification_counter,"all_notification" => $all_notification]);
               
            }elseif($request->notification_all == 'notification_all'){
                
                //for loading time view all unread notification 
                $all_notification = "";
                $all_notification_data = "";
              
                foreach(auth()->user()->unreadNotifications as $notification){
                    $all_notification_data = Carbon::parse($notification->created_at)->diffForHumans();
                    $all_notification .= "<a notification-id='".$notification->id."' class='d-flex' id='read-noti'>
                                        <div class='flex-shrink-0'>
                                            <figure class='avatar avatar-info me-3'>
                                                    <span class='avatar-text rounded-circle'>
                                                        <i class='bi bi-".$notification->data[1]."'></i>
                                                    </span>
                                            </figure>
                                        </div>
                                         <div class='flex-grow-1'>
                                            <p class='mb-0 fw-bold d-flex justify-content-between'>
                                                ".$notification->data[0]."
                                            </p>
                                            <span class='text-muted small'>
                                               <i class='bi bi-clock me-1'></i>".$all_notification_data."
                                            </span>
                                        </div></a></br>"; 
                }
                
                return Response()->json(["all_notification" => $all_notification,'notification_data' => $all_notification_data]);
            }elseif($request->read_all == "read_all"){
                
                $user = User::find(auth()->user()->id);
                $user->unreadNotifications->markAsRead();

                //count all unread notification 
                $notification_counter = auth()->user()->unreadNotifications()->groupBy('notifiable_type')->count();

                $notification_all = "<a notification-id='' id='read-noti'><p class='text-info mb-0 fw-bold d-flex justify-content-between'></p></a></br>";

                return Response()->json(["notification_counter" => $notification_counter,'notification_all' => $notification_all]);

            }elseif($request->chart_type == 'user chart'){
                    $users = role::select('roles.name')
                    ->withCount('user')
                    ->where('name','!=','SuperAdmin')
                    ->get(); 

                    return Response()->json(['user'=>$users]);

            }
        }
    }
}
