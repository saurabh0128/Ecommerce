<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Coupone;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItems;
use App\Models\UserAddress;
use Carbon\carbon;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth('api')->id();
        $purchase = Purchase::with('user','user_address','billing_address','purchase_item')->where('user_id',$user_id)->get();

        return Response()->json($purchase);
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
        // dd($request->all());
        $Validator = Validator::make($request->all(),[
            "customer_name"=>"nullable|regex:/^[\pL\s]+$/u",
            "deliveryAddress"=>"required",
            "billingAddress" =>"required",
            "product"=> "required",
            "qty"=>'required|max:10',
            "is_payed"=>"required",
            "payment_mode"=>"required",
            "transaction_no"=>"numeric|nullable|digits_between:3,30"
        ],
        [
            "regex"=>"only alphabet and space allowed"
        ]);

        if($Validator->fails())
        {
            return Response()->json(['error'=>$Validator->errors()->all()]);
        }else{

            $user =  auth('api')->user();
            
            $purchase = new Purchase;
        
            $purchase->user_id = $user->id;
            $purchase->customer_name = $user->user_name;
            $purchase->user_address_id = $request->deliveryAddress;
            $purchase->billing_address_id = $request->billingAddress;
            if(isset($request->coupon))
            {
                $purchase->coupon_id = $request->coupon;
            }
            $purchase->shipping_amt = 0;
            $purchase->total_amt = 0;
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

            $count = count($request->product);
            $total =  0;
            for($i=$count-1;$i>=0;$i--)
            {
                $purchase_item = new PurchaseItems;

                $purchase_item->purchase_id = $purchase->id;
                $products = Product::find($request->product[$i]);
                $purchase_item->product_id = $products->id;
                $purchase_item->product_name = $products->product_name;
                $purchase_item->product_desc = $products->product_desc;
                $purchase_item->qty =$request->qty[$i];
                $purchase_item->price = isset($products->special_price)?$products->special_price*$request->qty[$i]:$products->current_price*$request->qty[$i];
                $total += isset($products->special_price)?$products->special_price*$request->qty[$i]:$products->current_price*$request->qty[$i];
                $products->total_order += 1;
                $products->save();
                $purchase_item->save();
            }

            $purchase = Purchase::find($purchase->id);
            $purchase->total_amt = $total;

            $purchase->save();

            return Response()->json(['success'=>'Data Inserted Successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::with('user','user_address','billing_address','purchase_item')->findOrFail($id);

        return Response()->json($purchase);
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
        $purchase = Purchase::findOrFail($id);

        $purchase->purchase_status = "Cancel";

        $purchase->save();

        return Response()->json(['success' => 'Order Cancel Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
