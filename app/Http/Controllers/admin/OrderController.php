<?php 

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Coupone;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItems;
use App\Models\UserAddress;

use Illuminate\Database\QueryException;

use Carbon\carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('user_status','=',0)->get();
        $coupon = Coupone::all();
        $products = Product::all();
        return view('backend.order.create',compact('user','coupon','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "user" =>"required",
            "customer_name"=>"nullable|regex:/^[\pL\s]+$/u",
            "deliveryAddress"=>"required",
            "billingAddress" =>"required",
            "product"=> "required",
            "qty"=>'required|numeric|max:10',
            "is_payed"=>"required",
            "payment_mode"=>"required",
            "transaction_no"=>"numeric|nullable|min:3|max:30"
        ],
        [
            "regex"=>"only alphabet and space allowed"
        ]);

        $user = User::find($request->user);
        $products = Product::find($request->product);

        $purchase = new Purchase;
        $purchase_item = new PurchaseItems;

        $purchase->user_id = $request->user;
        $purchase->customer_name = $user->user_name;
        $purchase->user_address_id = $request->deliveryAddress;
        $purchase->billing_address_id = $request->billingAddress;
        if(isset($request->coupon))
        {
            $purchase->coupon_id = $request->coupon;
        }
        $purchase->shipping_amt = 0;
        $purchase->total_amt = isset($products->special_price)?$products->special_price:$products->current_price * $request->qty;
        $purchase->is_payed = $request->is_payed;
        $purchase->payment_mode = $request->payment_mode;
        if(isset($request->transaction_no))
        {
            $purchase->transaction_no = $request->transaction_no;
        }

     
        $purchase->purchase_date = carbon::parse(now())->format(env('APP_DATE_FORMAT'));
        $purchase->delivery_date = Carbon::now()->addDays(7)->format(env('APP_DATE_FORMAT'));
        $purchase->purchase_status = 'panding';
        $purchase->delivery_status = 'order request send to  seller';

        $purchase->save();

        $purchase_item->purchase_id = $purchase->id;
        $purchase_item->product_id = $request->product;
        $purchase_item->product_name = $products->product_name;
        $purchase_item->product_desc = $products->product_desc;
        // echo $request->qty;
        $purchase_item->qty = $request->qty;
        $purchase_item->price = isset($products->special_price)?$products->special_price:$products->current_price;
        $purchase_item->save();
        return redirect()->route('admin.order.index')->with('success','Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Purchase::with('user','user_address','billing_address','coupon','purchase_item')->where('id',$id)->firstOrFail();
        return view('backend.order.show',compact('order'));
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
        try {
            Purchase::find($id)->delete();
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Order directly , First delete a related records ']);
        }
    }


    public function ajax(Request $request)
    {
        if($request->ajax() && $request->mode == 'user_address_change')
        {
          $userAddresses = UserAddress::where('user_id',$request->id)->get();

          $str = "";

          foreach($userAddresses as $userAddress )
          {
              $str .= "<option value='".$userAddress->id."'>". $userAddress->address_line_1.$userAddress->address_line_2."</option>";
          }
          echo $str;
        }
        elseif($request->ajax() && $request->mode == 'datatable')
        {
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); 


             $columnIndex_arr = $request->get('order');
             $columnName_arr = $request->get('columns');
             $order_arr = $request->get('order');
             $search_arr = $request->get('search');

             $columnIndex = $columnIndex_arr[0]['column']; // Column index
             $columnName = $columnName_arr[$columnIndex]['data']; // Column name
             $columnSortOrder = $order_arr[0]['dir']; // asc or desc
             $searchValue = $search_arr['value']; // Search value

             // Total records
             $totalRecords = Purchase::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Purchase::select('count(*) as allcount')->where('customer_name', 'like', '%' .$searchValue . '%')->count();

             // DB::enableQueryLog();
             // Fetch records
             $records = Purchase::with('user')
               ->orderBy($columnName,$columnSortOrder)
               ->where('purchases.customer_name', 'like', '%' .$searchValue . '%')
               ->select('purchases.*')  
               ->skip($start)
               ->take($rowperpage)
               ->get();
            // dd(DB::getQueryLog());




                // dd($records->toArray()); 
             $data_arr = array();

             //for a counter 
             $count = 1;
            
             foreach($records as $record){
                $id = $record->id;
                $user_name = $record->user->name;
                $customer_name = $record->customer_name;
                $total_amt = $record->total_amt;
                $is_payed = $record->is_payed;

                $data_arr[] = array(
                  "id" => $count,
                  "user_id" => $user_name,
                  "customer_name" =>$customer_name,
                  "total_amt" =>$total_amt,
                  "is_payed" => $is_payed == 0 ? 'no':'yes',
                  "action" => '<a href="'.route('admin.order.show',$id).'"> <button type="button" class="btn btn-sm btn-warning" >View </button></a>  <button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button>'
                );
                $count++;
             }

             $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
             );

             echo json_encode($response);
             exit;
        }
    }
}
