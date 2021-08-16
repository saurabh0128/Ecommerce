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
        //dd($cart_detail);
        $coupon = Coupone::where('coupon_code',$request->coupon_code)->first();
       // dd($coupon);
        $date = Carbon::now();
        if($coupon->start_date <= $date->ToDateString() && $coupon->end_date >= $date->ToDateString())
        {
            if($coupon->user_id == auth('api')->id())
            {
                if($cart_detail->coupon_code)
                {
                    foreach($cart_detail->coupon_code as $key => $value){
                       
                        if($request->coupon_code == $value)
                        {
                            return Response()->json("This Coupone Alredy Apply");
                        }elseif($key == $coupon->coupon_type_value){
                            $coupon_detail = Coupone::where('coupon_code',$value)->first();
                            if($coupon_detail->discount_type == "fixed"){
                                $cart_detail->discount -= $coupon_detail->coupon_discount;
                            }elseif($coupon_detail->discount_type == "percentage"){
                                $cart_item = CartItem::where('product_id',$coupon_detail->coupon_type_value)->first();
                                $total_amt = $cart_item->price*$cart_item->quantity;
                                $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                $cart_detail->discount -= $discount;  
                            } 
                        }
                        if($key == $coupon->coupon_type_value)
                        {
                            return Response("ok");
                        }

                    }
                }
                 
                // $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                //     if($product){
                //         foreach($product as $key => $value){
                //             $discount_product = CartItem::where('product_id',$value->id)->first();
                //             echo $discount_product;
                //         }
                //     }
                if($coupon->coupon_type == "product")
                {
                    $product = Product::find($coupon->coupon_type_value);
                    $price = isset($product->special_price)?$product->special_price:$product->current_price;
                    if($coupon->discount_type == "fixed"){
                        $cart_detail->discount += $coupon->coupon_discount;
                    }elseif($coupon->discount_type == "percentage"){
                        $discount = $price/100*$coupon->coupon_discount;
                        $cart_detail->discount += $discount;
                    }
                    if(is_null($cart_detail->coupon_code))
                    {
                        $cart_detail->coupon_code =[
                           $product->id => $request->coupon_code
                        ];

                    }else{
                        $new_code = array_replace($cart_detail->coupon_code,[$product->id => $request->coupon_code]);
                        $cart_detail->coupon_code = $new_code;
                    }
                   // dd($cart_detail->coupon_code);
                   $cart_detail->save();
                }elseif($coupon->coupon_type == "category"){
                    $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                    
                    foreach($product as $value){
                        $discount_product = CartItem::where('product_id',$value->id)->first();
                        if(!is_null($discount_product)){
                        $cart_product = Cart::where('id',$discount_product->cart_id)->first();
                          
                            if($coupon->discount_type == "fixed"){
                                $cart_product->discount += $coupon->coupon_discount;
                                if(is_null($cart_detail->coupon_code))
                                {
                                    $cart_product->coupon_code =[
                                       $value->id => $request->coupon_code
                                    ];
                                }else{
                                    $new_code = array_replace($cart_detail->coupon_code,[$value->id => $request->coupon_code]);
                                    $cart_product->coupon_code = $new_code;
                                }
                                $cart_product->save();
                            }elseif($coupon->discount_type == "percentage"){
                                $discount = $discount_product->price/100*$coupon->coupon_discount;
                                $cart_product->discount += $discount;
                                
                                if(is_null($cart_detail->coupon_code))
                                {
                                    $cart_product->coupon_code =[
                                       $value->id => $request->coupon_code
                                    ];
                                }else{
                                    $new_code = array_replace($cart_detail->coupon_code,[$value->id => $request->coupon_code]);
                                    $cart_product->coupon_code = $new_code;
                                }
                                $cart_product->save();
                            }
                        }
                        
                    }
                    
                    
                }
               
            }else{
               foreach($cart_detail->coupon_code as $key => $value){

                    if($request->coupon_code == $value)
                    {
                        return Response()->json("This Coupone Alredy Apply");
                    }else{

                        if($key == $coupon->coupon_type_value){

                            $coupon_detail = Coupone::where('coupon_code',$value)->first();
                            // dd($coupon_detail);
                            if($coupon_detail->discount_type == "fixed"){
                                $cart_detail->discount -= $coupon_detail->coupon_discount;
                                // dd($cart_detail);
                            }elseif($coupon_detail->discount_type == "percentage"){
                                $cart_item = CartItem::where('product_id',$coupon_detail->coupon_type_value)->first();
                                $total_amt = $cart_item->price*$cart_item->quantity;
                                $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                $cart_detail->discount -= $discount;
                                //dd($cart_detail->discount);
                            }
                        }
                        
                    }
                } 
                if($coupon->coupon_type == "product"){
                    $product = Product::find($coupon->coupon_type_value);
                    $price = isset($product->special_price)?$product->special_price:$product->current_price;
                    if($coupon->discount_type == "fixed"){
                        $cart_detail->discount += $coupon->coupon_discount;
                    }elseif($coupon->discount_type == "percentage"){
                        $discount = $price/100*$coupon->coupon_discount;
                        $cart_detail->discount += $discount;
                    }
                    if(is_null($cart_detail->coupon_code))
                    {
                        $cart_product->coupon_code =[
                           $product->id => $request->coupon_code
                        ];
                    }else{
                        $new_code = array_replace( $cart_detail->coupon_code,[$product->id => $request->coupon_code]);
                        $cart_product->coupon_code = $new_code;
                    }
                  
                    // dd($cart_detail->discount);
                   $cart_detail->save();
                }elseif($coupon->coupon_type == "category"){
                    dd("cat");
                }
              $cart_detail->save();
            }
        }else{
            return Response()->json(["error" => "Sorry Coupon Has Exceeded"]);
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
        //
    }
}
