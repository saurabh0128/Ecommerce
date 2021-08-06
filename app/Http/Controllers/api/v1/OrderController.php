<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Coupone;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItems;
use App\Models\UserAddress;
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
        $purchase = Purchase::all();

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

        if($Validator->fails())
        {
            return Response()->json(['error'=>$Validator->errors()->all()]);
        }else{

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
        try {
            Purchase::where('id',$id)->delete();
            // return Response()->json(["success"=> 'Data Deleted Successfully']);
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Order directly , First delete a related records ']);
        }
    }
}
