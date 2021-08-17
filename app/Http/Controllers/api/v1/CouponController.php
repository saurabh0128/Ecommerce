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
       // dd($coupon);
        $date = Carbon::now();
        //check coupon date Not Exceeded 
        if($coupon->start_date <= $date->ToDateString() && $coupon->end_date >= $date->ToDateString())
        {
            //check Coupon Apply to User 
            if(!is_null($coupon->user_id))
            {
                //check This User Is Right To Apply Coupon
                if($coupon->user_id == auth('api')->id()){
                //check The Coupon code Is Enter 
                if($cart_detail->coupon_code)
                {
                    //loop For get All coupon Detail in User Cart
                    foreach($cart_detail->coupon_code as $key => $value){
                        //check User Apply Same Cuopon code or not
                        if($request->coupon_code == $value)
                        {
                            return Response()->json("This Coupone Alredy Apply");
                        }

                        $coupon_detail = Coupone::where('coupon_code',$value)->first();
                        // dd($coupon_detail);
                        //check Old Coupon type for remove 
                        // dd($coupon->coupon_type_value);
                        // =====================
                        if($key == $coupon_detail->coupon_type_value){
                            if($coupon_detail->coupon_type == "product"){
                                if($key == $coupon_detail->coupon_type_value){
                                    //dd($coupon_detail);
                                    //check old discount type for remove descount
                                    if($coupon_detail->discount_type == "fixed"){
                                       // dd($coupon_detail);
                                        $cart_detail->discount -= $coupon_detail->coupon_discount;
                                    //check old discount type for remove descount
                                    }elseif($coupon_detail->discount_type == "percentage"){
                                        $cart_item = CartItem::where('product_id',$coupon_detail->coupon_type_value)->first();
                                        //check Cart item iS get or Not 
                                        if(!is_null($cart_item)){
                                        $total_amt = $cart_item->price*$cart_item->quantity;
                                        $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                        $cart_detail->discount -= $discount;
                                        }
                                    }
                                }
                            
                            }
                        }
                        //check Old Coupon type for remove 
                        if($coupon_detail->coupon_type == "category"){  
                            $product = Product::where('category_id',$coupon_detail->coupon_type_value)->get();
                            dd($product);
                            if(!is_null($product)){
                               
                                dd($product);
                                //loop for Get all Products detail
                                foreach($product as $products){
                                    $discount_product = CartItem::where('product_id',$products->id)->first();
                                    //check Cart item iS get or Not
                                    if(!is_null($discount_product)){
                                        $coupon_detail = Coupone::where('coupon_code',$value)->first();
                                        //check old discount type for remove descount
                                        if($coupon_detail->discount_type == "fixed"){
                                            $cart_detail->discount -= $coupon_detail->coupon_discount;
                                        //check old discount type for remove descount
                                        }elseif($coupon_detail->discount_type == "percentage"){
                                            $cart_item = CartItem::where('product_id',$products->id)->first();
                                            $total_amt = $cart_item->price*$cart_item->quantity;
                                            $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                            $cart_detail->discount -= $discount; 
                                        }   
                                    }
                                }     
                            }
                        }
                    }
                   $cart_detail->save(); 
                }
                 
                
                if($coupon->coupon_type == "product")
                {
                    $product = Product::find($coupon->coupon_type_value);
                    $price = isset($product->special_price)?$product->special_price:$product->current_price;
                    $cart_item = CartItem::where('product_id',$coupon->coupon_type_value)->first();
                    //Check Enter coupon discount type
                    if($coupon->discount_type == "fixed"){
                        $cart_detail->discount += $coupon->coupon_discount;
                    }elseif($coupon->discount_type == "percentage"){
                        $total_amt = $cart_item->price*$cart_item->quantity;
                        $discount = $total_amt/100*$coupon->coupon_discount;
                        $cart_detail->discount += $discount;
                    }
                    //Check if add New Coupon COde Or Not
                    if(is_null($cart_detail->coupon_code))
                    {
                        $cart_detail->coupon_code =[
                           $product->id => $request->coupon_code
                        ];
                    }else{
                        $new_code = array_replace($cart_detail->coupon_code,[$product->id => $request->coupon_code]);
                        $cart_detail->coupon_code = $new_code;
                    }
                    $cart_detail->save();
                }elseif($coupon->coupon_type == "category"){
                    $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                    //Loop For Get all Detail About Peoduct In Same Category 
                    foreach($product as $value){
                        $discount_product = CartItem::where('product_id',$value->id)->first();
                        //check discount Product is get Or Not
                        if(!is_null($discount_product)){
                        $cart_product = Cart::where('id',$discount_product->cart_id)->first();
                            //Check Enter coupon discount type
                            if($coupon->discount_type == "fixed"){
                                $cart_product->discount += $coupon->coupon_discount;
                                // Check if add New Coupon COde Or Not
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

                                $total_amt = $discount_product->price*$discount_product->quantity;
                                $discount = $total_amt/100*$coupon->coupon_discount;
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
            }
            }else{
                //check The Coupon code Is Enter 
                if($cart_detail->coupon_code)
                {
                    //loop For get All coupon Detail in User Cart
                    foreach($cart_detail->coupon_code as $key => $value){
                        //check User Apply Same Cuopon code or not
                        if($request->coupon_code == $value)
                        {
                            return Response()->json("This Coupone Alredy Apply");
                        }

                        $coupon_detail = Coupone::where('coupon_code',$value)->first();
                        //check Old Coupon type for remove 
                        if($coupon_detail->coupon_type == "product"){
                            if($key == $coupon_detail->coupon_type_value){
                                //check old discount type for remove descount
                                if($coupon_detail->discount_type == "fixed"){
                                    $cart_detail->discount -= $coupon_detail->coupon_discount;
                                //check old discount type for remove descount
                                }elseif($coupon_detail->discount_type == "percentage"){
                                    $cart_item = CartItem::where('product_id',$coupon_detail->coupon_type_value)->first();
                                    //check Cart item iS get or Not 
                                    if(!is_null($cart_item)){
                                    $total_amt = $cart_item->price*$cart_item->quantity;
                                    $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                    $cart_detail->discount -= $discount;
                                    }
                                }
                            }
                        
                        }
                        //check Old Coupon type for remove 
                        if($coupon_detail->coupon_type == "category"){
                            
                            $product = Product::where('category_id',$coupon_detail->coupon_type_value)->get();
                            //loop for Get all Products detail
                            foreach($product as $products){
                                $discount_product = CartItem::where('product_id',$products->id)->first();
                                //check Cart item iS get or Not
                                if(!is_null($discount_product)){
                                    $coupon_detail = Coupone::where('coupon_code',$value)->first();
                                    //check old discount type for remove descount
                                    if($coupon_detail->discount_type == "fixed"){
                                        $cart_detail->discount -= $coupon_detail->coupon_discount;
                                    //check old discount type for remove descount
                                    }elseif($coupon_detail->discount_type == "percentage"){
                                        $cart_item = CartItem::where('product_id',$products->id)->first();
                                        $total_amt = $cart_item->price*$cart_item->quantity;
                                        $discount = $total_amt/100*$coupon_detail->coupon_discount;
                                        $cart_detail->discount -= $discount; 
                                    }   
                                }
                            }
                              
                        }
                    }
                    $cart_detail->save(); 
                }
                 
                
                if($coupon->coupon_type == "product")
                {
                    $product = Product::find($coupon->coupon_type_value);
                    $price = isset($product->special_price)?$product->special_price:$product->current_price;
                    $cart_item = CartItem::where('product_id',$coupon->coupon_type_value)->first();
                    //Check Enter coupon discount type
                    if($coupon->discount_type == "fixed"){
                        $cart_detail->discount += $coupon->coupon_discount;
                    }elseif($coupon->discount_type == "percentage"){
                        $total_amt = $cart_item->price*$cart_item->quantity;
                        $discount = $total_amt/100*$coupon->coupon_discount;
                        $cart_detail->discount += $discount;
                    }
                    //Check if add New Coupon COde Or Not
                    if(is_null($cart_detail->coupon_code))
                    {
                        $cart_detail->coupon_code =[
                           $product->id => $request->coupon_code
                        ];
                    }else{
                        $new_code = array_replace($cart_detail->coupon_code,[$product->id => $request->coupon_code]);
                        $cart_detail->coupon_code = $new_code;
                    }
                    $cart_detail->save();
                }elseif($coupon->coupon_type == "category"){
                    $product = Product::where('category_id',$coupon->coupon_type_value)->get();
                    //Loop For Get all Detail About Product In Same Category 
                    foreach($product as $value){
                        $discount_product = CartItem::where('product_id',$value->id)->first();
                        //check discount Product is get Or Not
                        if(!is_null($discount_product)){
                        $cart_product = Cart::where('id',$discount_product->cart_id)->first();
                            //Check Enter coupon discount type
                            if($coupon->discount_type == "fixed"){
                                $cart_product->discount += $coupon->coupon_discount;
                                // Check if add New Coupon COde Or Not
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

                                $total_amt = $discount_product->price*$discount_product->quantity;
                                $discount = $total_amt/100*$coupon->coupon_discount;
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
        $coupon_detail = Coupone::where('coupon_code',$id)->first();
        //dd($coupon_detail);
        $cart_detail = Cart::where('user_id',auth('api')->id())->first();
       // dd($coupon_detail);
        foreach($cart_detail->coupon_code as $key => $value){

            if($value == $id){

                if($coupon_detail->coupon_type == "product"){
                    //dd($coupon_detail);
                    if($coupon_detail->discount_type == "fixed")
                    {
                        $cart_detail->discount -= $coupon_detail->coupon_discount;
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
                        foreach($product as $value){
                            $cart_item = CartItem::where('product_id',$value->id)->first();
                            if(!is_null($cart_item)){

                            }
                        }
                    }

                }
            }

        }
        //return Response($coupon_detail);
    }
}
