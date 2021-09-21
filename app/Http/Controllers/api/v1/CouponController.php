<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupone;
use App\Models\Cart;
Use App\Models\CartItem;
use Carbon\carbon;
use App\Models\Product;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     


    public function index()
    {
        $cart_data = Cart::where('user_id',auth('api')->id())->select('discount','coupon_code')->first();
        if($cart_data->coupon_code == null)
        {
            return Response()->json(["status"=>false]);
        }else{
            return Response()->json(["status"=>true,"coupon_data"=>$cart_data]);
        }
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
        //Get User Cart detail 
        $cart_detail = Cart::where('user_id',auth('api')->id())->first();
        //Get User Enter Coupon DEtail 
        $coupon = Coupone::where('coupon_code',$request->coupon_code)->first();
        $discount = 0;
        $percentage_discount=0;
        $cart_total_amt = 0; 
        $date = Carbon::now();
        //Check User Enter Coupon is Exist in Coupon Table
        if(is_null($coupon)){
            return Response()->json(["status"=>false,"error" => "This Coupon Is Not Exist "]);
        }elseif(!($coupon->start_date <= $date->ToDateString() && $coupon->end_date >= $date->ToDateString())){
            return Response()->json(["status"=>false,"error" => "Sorry Coupon Has Expired"]);
        }elseif($coupon->coupon_code == $cart_detail->coupon_code){
            return Response()->json(["status"=>false,"error" =>"This Coupone Already Apply"]);
        //check Tha Coupon for User and This User is Eligible For This Coupon 
        }elseif($coupon->user_id && $coupon->user_id != auth('api')->id()){
            return Response()->json(["status"=>false,"error" =>"User Is Not Eligible For This Coupon"]);
        }else{
            if($coupon->coupon_type == "product"){

                //Get Product Detail Form Tha Cart Item 
                $cart_item = CartItem::where('product_id',$coupon->coupon_type_value)->where('cart_id',$cart_detail->id)->first();
                // dd($cart_item);

                if($cart_item){
                    if($coupon->discount_type == "fixed"){ 
                        $discount = $coupon->coupon_discount;   
                    }elseif($coupon->discount_type == "percentage"){
                        $product_total_amt = $cart_item->price*$cart_item->quantity;
                        $product_discount = $product_total_amt/100*$coupon->coupon_discount;
                        $discount = $product_discount;
                    }
                }
            }elseif($coupon->coupon_type == "category"){
                //Get All Cart Item With Relationship Products useing Product Id 
                $cart_item = CartItem::with('product')->where('cart_id',$cart_detail->id)->get();
                if($cart_item){
                    if($coupon->discount_type == "fixed"){
                        foreach($cart_item as $cart){
                            if($cart->product->category_id == $coupon->coupon_type_value){
                                $discount = $coupon->coupon_discount;                       
                            }
                        }
                    }
                    if($coupon->discount_type == "percentage"){
                        foreach($cart_item as $cart){
                            if($cart->product->category_id == $coupon->coupon_type_value){
                                $product_total_amt = $cart->price*$cart->quantity;
                                $percentage_discount += $product_total_amt/100*$coupon->coupon_discount;
                                $discount = $percentage_discount;                           
                            }     
                        }
                    }
                }
            }
            //Get All Product Data Into Tha Cart 
            $cart_product = CartItem::where('cart_id',$cart_detail->id)->get();
            foreach($cart_product as $products){
                $cart_total_amt += $products->price*$products->quantity;
            }
            $f_discount = min($cart_total_amt,$discount);
            if($discount != 0)
            {
                $cart_detail->discount = $f_discount;
                $cart_detail->coupon_code = $request->coupon_code;
                $cart_detail->save();
                return Response()->json(["status"=>true,"success" => "Coupon Added SuccessFully","discount"=>$f_discount]);
            }
            return Response()->json(["status"=>false,"error" => "Coupon Not Apply"]);
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
        $cart_data = Cart::where('user_id',auth('api')->id())->select('id','discount','coupon_code')->first();
        $coupon_data = Coupone::where('coupon_code',$cart_data->coupon_code)->first();
        $cart_item = CartItem::where('cart_id',$cart_data->id)->get();

        // echo $cart_data;
        // echo $coupon_data;
        // dd($cart_item);


        if($coupon_data->coupon_type == "product")
        {
            if($coupon_data->coupon_type_value == $id)
            {
                $cart_data->discount = 0;  
                $cart_data->coupon_code = null;
            }
        }

        $cart_data->save();
        // elseif($coupon->coupon_type == "category"){
        //     $product = Product::where('category_id',$coupon_data->coupon_type_value)->get();
        //     // $ar_length = max(count($cart_item),count($product));
        //     if($coupon->discount_type == 'fixed')
        //     {

        //     } 
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart_detail = Cart::where('user_id',auth('api')->id())->first();
        if(!($cart_detail->coupon_code == $id)){
            return Response()->json(["status"=>false,"error" => "Coupon Not Exist"]);   
        }else{
            $cart_detail->discount = 0;
            $cart_detail->coupon_code = Null;
        }
        $cart_detail->save();
        return Response()->json(["status"=>true,"success" => "Coupon Removed Successfully"]);
    }
}
