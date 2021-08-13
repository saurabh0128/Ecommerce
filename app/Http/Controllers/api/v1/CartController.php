<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Coupone;

class CartController extends Controller
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
        $cartdata =Cart::where('user_id','=',auth('api')->id())->first();
        //User Create new cart Or Not
        if(is_null($cartdata)){
            //New User Cart
            $cart = new Cart;
            $product_data = Product::find($request->product_id);
            $cart_item = new CartItem;
            
            $cart->user_id = auth('api')->id();
            $cart->shipping_charges = 1500;
            $cart->save();
            //User apply Any Coupon Or Not
            if(isset($request->coupon_code)){
                $coupon = Coupone::where('coupon_code',$request->coupon_code)->firstOrFail();
                $cart->coupon_code =[
                   $request->product_id => $request->coupon_code
                ];
                $price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                //chaeck Discount Type is Rupees Or Percentafes
                if($coupon->discount_type == "Rupees"){
                    $cart->discount = $coupon->coupon_discount;       
                }elseif($coupon->discount_type == "Percentage"){
                    $discount = $price/100*$coupon->coupon_discount;
                    $cart->discount = $discount;
                }
            }

            $cart->save();

            $cart_item->cart_id = $cart->id;
            $cart_item->product_id = $request->product_id;
            $cart_item->name = $product_data->product_name;
            $cart_item->price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
            $cart_item->image = $product_data->product_img;
            $cart_item->quantity = 1;

            $cart_item->save();

            return Response()->json(["success" => "Product Add SuccessFully"]);
        }else{
            //Old User Cart
            $cart = Cart::where('user_id',auth('api')->id())->first();
            $product_data =  Product::find($request->product_id);
            $Old_product = CartItem::where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
                  
            //User Add New Peoduct Or Not
            if(is_null($Old_product))
            {   //User Add New Product
                $cart_item = new CartItem;
                    
                $cart_item->cart_id = $cart->id;
                $cart_item->product_id = $request->product_id;
                $cart_item->name = $product_data->product_name;
                $cart_item->price =  isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                $cart_item->image = $product_data->product_img;
                $cart_item->quantity = 1;

                $cart_item->save();
                         
                //User apply Any Coupon Or Not
                if(isset($request->coupon_code)){
                    $coupon = Coupone::where('coupon_code',$request->coupon_code)->first();
                    $user_coupon = Cart::where('user_id',auth('api')->id())->first();
                    $code = count($user_coupon->coupon_code)+1;

                    $new_code = array_replace( $user_coupon->coupon_code,[$request->product_id => $request->coupon_code]);
                
                    $cart->coupon_code = $new_code;
                    $price = isset($product_data->special_price)?$product_data->special_price:$product_data->current_price;
                    //chaeck Discount Type is Rupees Or Percentafes
                    if($coupon->discount_type == "Rupees"){
                        $cart->discount += $coupon->coupon_discount;
                     
                    }elseif($coupon->discount_type == "Percentage"){
                        $discount = $price/100*$coupon->coupon_discount;
                        $cart->discount += $discount;
                    }   
                    $cart->save();
                    return Response()->json(["success" => "Product Add SuccessFully"]);
                }
               
            }else{
                //User Add Old Product
                //=======================strat with (coupon add or not if not is not working )
                $product = CartItem::where('cart_id',$cart->id)->where('product_id',"=",$request->product_id)->firstOrFail(); 
                $product->quantity += 1; 
                $user_coupon = Cart::where('user_id',auth('api')->id())->firstOrFail();
                $coupons = $user_coupon->coupon_code;
                // get All Coupon in tha User cart
                foreach($coupons as $key => $value)
                {
                    if($key == $request->product_id)
                    {
                        $one_coupon = Coupone::where('coupon_code',$value)->firstOrFail();
                        //chaeck Discount Type is Rupees Or Percentafes
                        if($one_coupon->discount_type == "Rupees"){
                            $user_coupon->discount -= $one_coupon->coupon_discount;
                        }elseif($one_coupon->discount_type == "Percentage"){
                            $discount = $product->price/100*$one_coupon->coupon_discount;
                            $user_coupon->discount -= $discount;
                        }
                    }
                }
                $coupon_detail = Coupone::where('coupon_code',$request->coupon_code)->firstOrFail();

                //chaeck Discount Type is Rupees Or Percentafes
                if($coupon_detail->discount_type == "Rupees"){
                    $user_coupon->discount +=$coupon_detail->coupon_discount;
                }elseif($coupon_detail->discount_type == "Percentage"){
                    $discount = $product->price/100*$coupon_detail->coupon_discount;
                    $user_coupon->discount += $discount;
                }
                //Add New Coupon In User cart
                $user_coupon->coupon_code= array_replace( $user_coupon->coupon_code,[$request->product_id => $request->coupon_code]);

                $user_coupon->save();
                $product->save();

                return Response()->json(["success" => "Product Add SuccessFully"]);   
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
        $cart = Cart::with('CartItem')->where('id',$id)->first();

        //count all cartitem in tha cart
        $total = count($cart->CartItem);
        $subtotal = 0;
        for($i=0;$i<$total;$i++)
        {
            //sum all Product price in tha cart
            $subtotal += $cart->CartItem[$i]['price']*$cart->CartItem[$i]['quantity'];
        }
        //sum shipping charges and decrease discount 
        $total_amt = $subtotal-$cart->discount+$cart->shipping_charges;
        
        return Response()->json(['cart' => $cart, '$subtotal' => $subtotal,'total_amt' => $total_amt]);
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
    public function update(Request $request,$id)
    {
        $cart = Cart::where('user_id','=',auth('api')->id())->firstOrFail();
        $cart_item = CartItem::find($id);
        $coupons = $cart->coupon_code;
        if($request->quantity > $cart_item->quantity){
            $price = $cart_item->price*($request->quantity-$cart_item->quantity); 
              
            foreach($coupons as $key => $value)
            {
                if($cart_item->product_id == $key)
                {
                    $one_coupon = Coupone::where('coupon_code',$value)->firstOrFail();
                    return Response($one_coupon);
                }
            }

           // return Response($price);
            // $price = $cart_item->price*($request->quantity-$cart_item->quantity);
            // $cart_item->quantity = $request->quantity;
            // $cart->subtotal += $price;
            // $cart->total += $price;
            
            // $cart_item->save();
            // $cart->save();

            // return Response()->json(["success" => "Quantity Updated Successfully"]);
            
        }else{
            
            $price = $cart_item->price*($cart_item->quantity-$request->quantity);
            $cart_item->quantity = $request->quantity;
            $cart->subtotal -= $price;
            $cart->total -= $price;
            
            // $cart_item->save();
            // $cart->save();

            // return Response()->json(["success" => "Quantity Updated Successfully"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart_item = CartItem::find($id);
        $cart = Cart::where('user_id',auth('api')->id())->firstOrFail();

        $price = $cart_item->price*$cart_item->quantity;
        $cart->subtotal -= $price;
        $cart->total -= $price;
        // dd($cart->total);
        $cart->save();

        $cart_item = CartItem::find($id)->delete();

        return Response()->json(["success" => "Product Delete Successfully"]);
    }
}
