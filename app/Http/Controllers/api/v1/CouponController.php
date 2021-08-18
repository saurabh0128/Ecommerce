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
        //
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
        $cart_detail = Cart::where('user_id',auth('api')->id())->first();
        $coupon = Coupone::where('coupon_code',$request->coupon_code)->first();
        //dd($coupon);
        $date = Carbon::now();
        if(is_null($coupon)){
            return Response()->json(["error" => "This Coupon Is Not Exist "]);
        }elseif(!($coupon->start_date <= $date->ToDateString() && $coupon->end_date >= $date->ToDateString())){
            return Response()->json(["error" => "Sorry Coupon Has Exceeded"]);
        }elseif($coupon->coupon_code == $cart_detail->coupon_code){
            return Response()->json(["error" =>"This Coupone Alredy Apply"]);
        }elseif(!$coupon->user_id){
            if($coupon->coupon_type == "product")
            {
                if($coupon->discount_type == "fixed"){
                    $cart_detail->discount = $coupon->coupon_discount;
                    $cart_detail->coupon_code = $request->coupon_code;
                }elseif($coupon->discount_type == "percentage"){
                    $product_detail = CartItem::where('product_id',$coupon->coupon_type_value)->first();
                    $product_total_amt = $product_detail->price*$product_detail->quantity;
                    $product_discount = $product_total_amt/100*$coupon->coupon_discount;
                    $cart_detail->discount = $product_discount;
                    $cart_detail->coupon_code = $request->coupon_code;
                    //dd($cart_detail);
                }
            }elseif($coupon->coupon_type == "category"){
                if($coupon->discount_type == "fixed"){
                    $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                    foreach($product as $product_detail){
                        $cart_item = CartItem::where('product_id',$product_detail->id)->first();
                        if($cart_item){
                            $cart_detail->discount = $coupon->coupon_discount;
                            $cart_detail->coupon_code = $request->coupon_code;
                            break;            
                        }
                    }
                }elseif($coupon->discount_type == "percentage"){
                    $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                    foreach($product as $product_detail){
                        $cart_item = CartItem::where('product_id',$product_detail->id)->first();
                        if($cart_item){
                            //===========================
                        }
                    }
                }
            }
            //$cart_detail->save();
            return Response()->json(["success" => "Coupon Add SuccessFully"]);
        }else{
            if(!($coupon->user_id == auth('api')->id()))
            {
                return Response()->json(["error" =>"This Coupone is Not valida"]);
            }else{
                dd("apply");
            }
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
        $coupon_detail = Coupone::where('coupon_code',$id)->first();
        //dd($coupon_detail);
        $cart_detail = Cart::where('user_id',auth('api')->id())->first();
       // dd($coupon_detail);
        foreach($cart_detail->coupon_code as $key => $value){

            if($value == $id){

                if($coupon_detail->coupon_type == "product"){
                   
                    if($coupon_detail->discount_type == "fixed")
                    {
                        $cart_detail->discount -= $coupon_detail->coupon_discount;
                       
                       // dd($cart_detail->discount);
                        $coupon_delete =$cart_detail->coupon_code;
                        unset($coupon_delete[$coupon_detail->coupon_type_value]);
                        $cart_detail->coupon_code = $coupon_delete;
                        $cart_detail->save();
                    }elseif($coupon_detail->discount_type == "percentage"){
                        $cart_item = CartItem::where('product_id',$coupon_detail->coupon_type_value)->first();
                        $total_amt = $cart_item->price*$cart_item->quantity;
                        $discount = $total_amt/100*$coupon_detail->coupon_discount;
                        $cart_detail->discount -= $discount;
                        $coupon_delete =$cart_detail->coupon_code;
                        unset($coupon_delete[$coupon_detail->coupon_type_value]);
                        $cart_detail->coupon_code = $coupon_delete;
                        $cart_detail->save();
                    }   
                    
                }elseif($coupon_detail->coupon_type == "category"){
                    if($coupon_detail->discount_type == "fixed")
                    {
                        $cart_detail->discount -= $coupon_detail->coupon_discount;
                        $coupons_detail =$cart_detail->coupon_code;
                        $coupon_delete=array_diff($coupons_detail,[$id]);
                        $cart_detail->coupon_code = $coupon_delete;
                        $cart_detail->save();
                    }elseif($coupon_detail->discount_type == "percentage"){
                        $product = Product::where('category_id',$coupon_detail->coupon_type_value)->get();
                        foreach($product as $product_detail){
                            $cart_item = CartItem::where('product_id',$product_detail->id)->first();
                            if(!is_null($cart_item)){
                                $discount_product = CartItem::where('product_id',$product_detail->id)->first();
                                 if(!is_null($discount_product)){
                                    $cart_item = CartItem::where('product_id',$product_detail->id)->first();
                                    $total_amt = $cart_item->price*$cart_item->quantity;
                                    $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                    $cart_detail->discount -= $discount;
                                    $coupons_detail = $cart_detail->coupon_code;
                                    $coupon_delete=array_diff($coupons_detail,[$id]);
                                    $cart_detail->coupon_code = $coupon_delete;
                                    $cart_detail->save();
                                }
                            }
                        }
                    }

                }
            }

        }
        //return Response($coupon_detail);
    }
}
