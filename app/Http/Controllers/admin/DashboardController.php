<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\Purchase;
use App\Models\User;
use DB;

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

        
        foreach($orders as $order)
        {
            array_push($monthArray,$order->date);
        }
         // $months = array_unique($months);

        // dd($monthArray);

        return view('backend.dashboard.index',compact('monthArray'));
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
                $order = Purchase::withCount('purchases')->select(DB::raw('DATE_FORMAT(`created_at`,"%d %M %Y") as x'),DB::raw('Count(*) as y '))
                ->groupBy('x')
                ->whereYear('created_at',$month_year[1])
                ->whereMonth('created_at',date('m',strtotime($month_year[0])))
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
                foreach($user->unreadNotifications as $notification){
                    $all_notification .= "<a notification-id='".$notification->id."' id='read-noti'><p class='mb-0 fw-bold d-flex justify-content-between'>".$notification->data[0]."</p></a></br>"; 
                }
                
                return Response()->json(["notification_count" => $notification_counter,"all_notification" => $all_notification]);
               
            }elseif($request->notification_all == 'notification_all'){
                
                //for loading time view all unread notification 
                $all_notification = "";
                foreach(auth()->user()->unreadNotifications as $notification){
                    $all_notification .= "<a notification-id='".$notification->id."'id='read-noti'><p class='mb-0 fw-bold d-flex justify-content-between'>".$notification->data[0]."</p></a></br>"; 
                }
                
                return Response()->json(["all_notification" => $all_notification]);
            }elseif($request->read_all){
                
                $user = User::find(auth()->user()->id);
                $user->unreadNotifications->markAsRead();

                //count all unread notification 
                $notification_counter = auth()->user()->unreadNotifications()->groupBy('notifiable_type')->count();

                $notification_all = "<a notification-id='' id='read-noti'><p class='mb-0 fw-bold d-flex justify-content-between'></p></a></br>";

                return Response()->json(["notification_counter" => $notification_counter,'notification_all' => $notification_all]);

            }
        }
    }
}
